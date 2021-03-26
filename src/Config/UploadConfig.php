<?php

namespace FileManager\Config;

/**
 * Class UploadConfig.
 *
 * Enables loading a config settings from the Laravel Config facade.
 */
class UploadConfig extends AbstractConfig
{
    /**
     * The file name of the config.
     */
    const FILE_NAME = 'file-manager';

    /**
     * Returns a list custom handlers (custom, override).
     *
     * @return array
     */
    public function handlers()
    {
        return [];
    }

    /**
     * Returns the disk name to use for the chunk storage.
     *
     * @return string
     */
    public function chunksDiskName()
    {
        return $this->get('temp_disk');
    }

    /**
     * The storage path for the chunks.
     *
     * @return string the full path to the storage
     *
     * @see UploadConfig::get()
     */
    public function chunksStorageDirectory()
    {
        return 'chunks';
    }

    /**
     * Returns the time stamp string for clear command.
     *
     * @return string
     *
     * @see UploadConfig::get()
     */
    public function clearTimestampString()
    {
        return $this->get('clear.timestamp');
    }

    /**
     * Returns the shedule config array.
     *
     * @return array<enable,cron>
     */
    public function scheduleConfig()
    {
        return $this->get('clear.schedule');
    }

    /**
     * Should the chunk name add a session?
     *
     * @return bool
     */
    public function chunkUseSessionForName()
    {
        return true;
    }

    /**
     * Should the chunk name add a ip address?
     *
     * @return bool
     */
    public function chunkUseBrowserInfoForName()
    {
        return false;
    }

    /**
     * Returns a chunks config value.
     *
     * @param string     $key     the config name is prepended to the key value
     * @param mixed|null $default
     *
     * @return mixed
     *
     * @see \Config::get()
     */
    public function get($key, $default = null)
    {
        return config(self::FILE_NAME.'.'.$key, $default);
    }
}
