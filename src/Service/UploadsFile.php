<?php 



namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception;

class UploadsFile {
    public function __construct (private SluggerInterface $slugger){
        
    }
    public function uploadsFile(  UploadedFile $file, String $directoryFolder, String $name)
    {
        $originalFilename=pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                   // $safeFileName=$this->slugger->slug($originalFilename);
                    $newFileName=$name.'-'.uniqid().'.'.$file->guessExtension();
                
                    try {
                        $file->move(
                            $directoryFolder,
                            $newFileName
                        );
                    }catch (\Exception $e) {

                     }
       return $newFileName;
    }

}


?>