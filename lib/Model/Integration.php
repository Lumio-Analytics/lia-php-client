<?php
/**
 * Copyright © 2019 Lumio Analytics. All rights reserved.
 */

namespace Lumio\IntegrationAPI\Model;

class Integration
{
    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @var string[]
     */
    protected static $fieldFormats = array(
        'id'               => array('required' => false, 'format' => '/array(0-9a-fA-F]{5,25}/'),
        'key'              => array('required' => true, 'format' => '/^\w{40}$/'),
        'url'              => array('required' => true, 'format' => '/https?:\/\/.*/'),
        'platform'         => array('required' => true, 'format' => '/^.{0,64}$/'),
        'platform_version' => array('required' => true, 'format' => '/^.{0,16}$/'),
        'plugin'           => array('required' => true, 'format' => '/^.{0,64}$/'),
        'plugin_version'   => array('required' => true, 'format' => '/^.{0,16}$/'),
        'status'           => array('required' => true, 'format' => '/^(in)?active$/'),
        'create_date'      => array('required' => false, 'format' => '/\d{10}/'),
        'update_date'      => array('required' => false, 'format' => '/\d{10}/'),
        );
    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = array();

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['id']               = isset($data['id']) ? $data['id'] : null;
        $this->container['key']              = isset($data['key']) ? $data['key'] : null;
        $this->container['url']              = isset($data['url']) ? $data['url'] : null;
        $this->container['platform']         = isset($data['platform']) ? $data['platform'] : null;
        $this->container['platform_version'] = isset($data['platform_version']) ? $data['platform_version'] : null;
        $this->container['plugin']           = isset($data['plugin']) ? $data['plugin'] : null;
        $this->container['plugin_version']   = isset($data['plugin_version']) ? $data['plugin_version'] : null;
        $this->container['create_date']      = isset($data['create_date']) ? $data['create_date'] : null;
        $this->container['update_date']      = isset($data['update_date']) ? $data['update_date'] : null;

        $this->setStatus($data['status']);
    }

    /**
     * Gets id
     *
     * @return string
     */
    public function getId()
    {
        return $this->container['id'];
    }

    /**
     * Sets id
     *
     * @param string $id id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->container['id'] = $id;

        return $this;
    }

    /**
     * Gets key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->container['key'];
    }

    /**
     * Sets key
     *
     * @param string $key key
     *
     * @return $this
     */
    public function setKey($key)
    {
        $this->container['key'] = $key;

        return $this;
    }

    /**
     * Gets url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->container['url'];
    }

    /**
     * Sets url
     *
     * @param string $url url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->container['url'] = $url;

        return $this;
    }

    /**
     * Gets platform
     *
     * @return string
     */
    public function getPlatform()
    {
        return $this->container['platform'];
    }

    /**
     * Sets platform
     *
     * @param string $platform platform
     *
     * @return $this
     */
    public function setPlatform($platform)
    {
        $this->container['platform'] = $platform;

        return $this;
    }

    /**
     * Gets platform_version
     *
     * @return string
     */
    public function getPlatformVersion()
    {
        return $this->container['platform_version'];
    }

    /**
     * Sets platform_version
     *
     * @param string $platform_version platform_version
     *
     * @return $this
     */
    public function setPlatformVersion($platform_version)
    {
        $this->container['platform_version'] = $platform_version;

        return $this;
    }

    /**
     * Gets plugin
     *
     * @return string
     */
    public function getPlugin()
    {
        return $this->container['plugin'];
    }

    /**
     * Sets plugin
     *
     * @param string $plugin plugin
     *
     * @return $this
     */
    public function setPlugin($plugin)
    {
        $this->container['plugin'] = $plugin;

        return $this;
    }

    /**
     * Gets plugin_version
     *
     * @return string
     */
    public function getPluginVersion()
    {
        return $this->container['plugin_version'];
    }

    /**
     * Sets plugin_version
     *
     * @param string $plugin_version plugin_version
     *
     * @return $this
     */
    public function setPluginVersion($plugin_version)
    {
        $this->container['plugin_version'] = $plugin_version;

        return $this;
    }

    /**
     * Gets status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->container['status'];
    }

    /**
     * Sets status
     *
     * @param string $status status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        if ($status && $status !== 'inactive') {
            $this->container['status'] = 'active';
        } else {
            $this->container['status'] = 'inactive';
        }

        return $this;
    }

    /**
     * Gets create_date
     *
     * @return string
     */
    public function getCreateDate()
    {
        return $this->container['create_date'];
    }

    /**
     * Sets create_date
     *
     * @param string $create_date create_date
     *
     * @return $this
     */
    public function setCreateDate($create_date)
    {
        $this->container['create_date'] = $create_date;

        return $this;
    }

    /**
     * Gets update_date
     *
     * @return string
     */
    public function getUpdateDate()
    {
        return $this->container['update_date'];
    }

    /**
     * Sets update_date
     *
     * @param string $update_date update_date
     *
     * @return $this
     */
    public function setUpdateDate($update_date)
    {
        $this->container['update_date'] = $update_date;

        return $this;
    }


    public function validate()
    {
        foreach ($this->container as $key => $value) {
            if (self::$fieldFormats[$key]['required'] && is_null($value)) {
                return false;
            }
            if (!is_null($value) && !preg_match(self::$fieldFormats[$key]['format'], $value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                //Will work while we don't deal with booleans or empty strings
                array_filter($this->container)
            );
        }

        return json_encode($this->container);
    }
}
