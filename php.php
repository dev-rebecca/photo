<?php


$dbURI = 'mysql:host=localhost;port=8889;dbname=wildlife-watcher';
$dbconn = new PDO($dbURI, 'user1', 'user1');

function upload_to_db($photo) {
  global $dbconn;
  $sql = "INSERT INTO image_test (image) 
          VALUES (:i)";
  $stmt = $dbconn->prepare($sql);
  $stmt->bindParam(':i', $photo, PDO::PARAM_STR);
  $stmt->execute();
  if ($stmt->rowCount() > 0) { 
      return true;
  }
  return false;
}


if(isset($_FILES['sample_image']))
{

	$extension = pathinfo($_FILES['sample_image']['name'], PATHINFO_EXTENSION);

	$new_name = time() . '.' . $extension;

	move_uploaded_file($_FILES['sample_image']['tmp_name'], 'images/' . $new_name);

	$data = array(
		'image_source'		=>	'images/' . $new_name
	);

  upload_to_db($new_name);
	echo json_encode($data);

}

// View image
function viewImage ($id) {
  global $dbconn;
  $sql = "SELECT image FROM image_test WHERE id = :id";
  $stmt = $dbconn->prepare($sql);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  if ($stmt->rowCount() > 0) {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  return false;
}

if (isset($_POST['id'])) {
  // $image = viewImage($_POST['id']);
  // echo($image);
  $imagePath="http://localhost:8080/photo/images/";
  $image="1636005865.png";
  echo($imagePath . $image);

}

?>
