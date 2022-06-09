<?php

declare(strict_types=1);

namespace Askwey\App\Common\Components;

use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

final class ImageUploader
{
    protected string $staticPath;
    protected ?string $currentImage;
    protected UploadedFile $file;

    public function __construct()
    {
        $this->staticPath = \Yii::getAlias('@app' . '/public/static/');
    }

    // todo: Реализовать возможность группировки сохраняемых изображений по директориям.
    public function uploadImageByModel(ActiveRecord|Model $model, string $attribute, bool $deleteCurrent = true): string|false
    {
        $this->file = UploadedFile::getInstance($model, $attribute);
        $this->setCurrentImagePath($model->$attribute);

        if ($deleteCurrent && $this->isExist())
            $this->deleteImage();

        return $this->saveImage();
    }

    protected function deleteImage(): bool
    {
        return unlink($this->currentImage);
    }

    protected function saveImage(): string|false
    {
        $filename = $this->generateFilename();
        return $this->file->saveAs($this->staticPath . $filename)
            ? $filename : false;
    }

    protected function isExist(): bool
    {
        return !is_null($this->currentImage) && file_exists($this->staticPath . $this->currentImage);
    }

    protected function generateFilename(): string
    {
        return sprintf('%s.%s', \Yii::$app->security->generateRandomString(), $this->file->extension);
    }

    protected function setCurrentImagePath(string $currentImage, string $className = null): void
    {
        $this->currentImage = $this->staticPath . $currentImage;
    }

}