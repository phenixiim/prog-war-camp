<?php

interface IDownloader
{
    public function download(string $url): string;
}