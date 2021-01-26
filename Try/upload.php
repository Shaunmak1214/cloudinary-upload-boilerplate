<?php

$fileName = $_FILES['file']['name'];
$fileTmpName = $_FILES['file']['tmp_name'];
$fileSize = $_FILES['file']['size'];
$fileType = $_FILES['file']['type'];
$fileError = $_FILES['file']['error'];

$fileExt = explode('.', $fileName);
$fileActualExt = strtolower(end($fileExt));

$allowed = array('jpg', 'jpeg', 'png', 'svg');

if(in_array($fileActualExt, $allowed)){

    if($fileError === 0){

        $fileNameNew = uniqid('', true).".".$fileActualExt;

        /* $fileDestination = "upload/".$fileNameNew; */
        echo $fileTmpName;
        /* move_uploaded_file($fileTmpName, $fileDestination); */

        echo "File uploaded";

    }else{

        echo "There was an error uploading your file";

    }

}else{

    echo "You cannot upload files of this type!";

}

if (is_file(__DIR__ . '/../vendor/autoload.php') && is_readable(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__.'/../vendor/autoload.php';
} else {
    // Fallback to legacy autoloader
    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../vendor/cloudinary/cloudinary_php/src/Helpers.php';
}

if (file_exists('settings.php')) {
    include './settings.php';
}

$sample_paths = array(
    'pizza' => getcwd() . DIRECTORY_SEPARATOR . 'pizza.jpg',
    'lake' => getcwd() . DIRECTORY_SEPARATOR . 'lake.jpg',
    'couple' => $fileTmpName,
);


$default_upload_options = array('tags' => 'basic_sample');
$eager_params = array('width' => 200, 'height' => 150, 'crop' => 'scale');
$files = array();

/* function do_uploads()
{ */
    global $files, $sample_paths, $default_upload_options, $eager_params;

/*     $files['remote_trans'] = \Cloudinary\Uploader::upload(
        $sample_paths['couple'],
        array_merge(
            $default_upload_options,
            array(
                'width' => 500,
                'height' => 500,
                'crop' => 'fit',
                'effect' => 'saturation:-70',
            )
        )
    ); */

    echo "uploading";

    # In the two following examples, the file is fetched from a remote URL and stored in Cloudinary.
    # This allows you to apply the same transformations, and serve those using Cloudinary's CDN layer.
    $files['remote'] = \Cloudinary\Uploader::upload(
        $sample_paths['couple'],
        $default_upload_options
    );

    echo cloudinary_url($files['remote']['public_id']);

/* }  */

?>