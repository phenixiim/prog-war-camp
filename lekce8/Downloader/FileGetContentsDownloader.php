<?php

class FileGetContentsDownloader implements IDownloader
{
    public function download(string $url): string
    {
        return file_get_contents($url);
    }
}