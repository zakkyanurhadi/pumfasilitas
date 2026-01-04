<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = service('session');
    }

    /**
     * Convert uploaded image to WebP format
     * 
     * @param \CodeIgniter\HTTP\Files\UploadedFile $imageFile
     * @param string $targetPath
     * @param int $quality
     * @return string|null New filename with .webp extension
     */
    protected function convertImageToWebP($imageFile, $targetPath, $quality = 80)
    {
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            // Generate a random name without extension
            $randomName = $imageFile->getRandomName();
            $nameWithoutExt = pathinfo($randomName, PATHINFO_FILENAME);
            $webpName = $nameWithoutExt . '.webp';

            // Ensure target directory exists
            if (!is_dir($targetPath)) {
                mkdir($targetPath, 0777, true);
            }

            // Path for temporary original file and final webp file
            $tempPath = $targetPath . DIRECTORY_SEPARATOR . $randomName;
            $webpFullPath = $targetPath . DIRECTORY_SEPARATOR . $webpName;

            // Move the uploaded file to temp location
            $imageFile->move($targetPath, $randomName);

            try {
                // Initialize Image service
                $image = \Config\Services::image();

                // Load, resize if needed (optional optimization), and convert to WebP
                // We set max width 1200px to prevent huge images from slowing down the site
                $image->withFile($tempPath)
                    ->resize(1200, 1200, true, 'height') // Maintain aspect ratio, max 1200px
                    ->save($webpFullPath, $quality);

                // Delete the original temporary file
                if (file_exists($tempPath)) {
                    unlink($tempPath);
                }

                return $webpName;
            } catch (\Exception $e) {
                // If conversion fails, keep the original name but it might be problematic 
                // since we expect .webp. Log the error.
                log_message('error', 'WebP Conversion Error: ' . $e->getMessage());
                return $randomName;
            }
        }
        return null;
    }
}
