<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
$servername = "127.0.0.1";
$username = "";
$password = "";
$dbname = "launchbox";

//conversor a UTF8
function utf8_converter($array)
{
  array_walk_recursive($array, function (&$item, $key) {
    if (!mb_detect_encoding($item, "utf-8", true)) {
      $item = utf8_encode($item);
    }
  });

  return $array;
}

function selectParamsPDO($query, $vars, $binds)
{
  global $servername, $dbname, $username, $password;
  try {
    $dsn = "mysql:host=$servername;dbname=$dbname";
    $dbh = new PDO($dsn, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare($query);
    if ($vars) {
      for ($i = 0; $i <= sizeof($vars) - 1; $i++) {
        $stmt->bindParam("$binds[$i]", $vars[$i], PDO::PARAM_STR);
      }
    }

    //$stmt->bindParam(":type", $type, PDO::PARAM_STR);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    $myArray = [];
    while ($row = $stmt->fetch()) {
      $myArray[] = $row;
    }
    if ($myArray == null) {
      return http_response_code(500);
    }
    $dbh = null;
    return $myArray;
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

$platforms = selectParamsPDO("SELECT DISTINCT Platform FROM games", [], []);
$i = 0;

foreach ($platforms as &$platform) {
  $platformName = $platform["Platform"];

  $gameNames = selectParamsPDO(
    "SELECT games.DatabaseID, games.Name, games.CommunityRating, games.Genres from games WHERE games.Platform  = '$platformName'",
    [],
    []
  );
  foreach ($gameNames as &$gameName) {
    $gameDatabaseID = $gameName["DatabaseID"];
    $gameName = $gameName["Name"];
    $gamCommunityRating = $gameName["CommunityRating"];
    $gameGenres = $gameName["Genres"];

    // $array["platform"][$platformName]["Games"][$gameName][
    //   "DatabaseID"
    // ] = $gameDatabaseID;

    //     $array["platform"][$platformName]["Games"][$gameName][
    //       "CommunityRating"
    //     ] = $gamCommunityRating;
    //
    //     $array["platform"][$platformName]["Games"][$gameName][
    //       "Genres"
    //     ] = $gameGenres;

    $gameMedias = selectParamsPDO(
      "SELECT filename, type from images_temp3 WHERE DatabaseID = '$gameDatabaseID'",
      [],
      []
    );
    foreach ($gameMedias as &$gameMedia) {
      $gameMediaFilename = $gameMedia["filename"];
      $gameMediaType = $gameMedia["type"];

      $array["platform"][$platformName]["games"][$gameName]["medias"][
        $gameMediaType
      ] = "https://images.launchbox-app.com/" . $gameMediaFilename;
    }
  }

  print_r($array);

  $json = json_encode(utf8_converter($array));
  $fp = fopen("$platformName.json", "w");
  fwrite($fp, $json);
  fclose($fp);

  $i++;
}
