<?php

namespace Rewake\Sendlane;


/**
 * Class SendlaneClient
 * @package Rewake\Sendlane
 */
class SendlaneClient
{
    /**
     * @var string
     */
    private $version = 'v1';

    /**
     * @var string
     */
    private $subdomain;

    /**
     * @var array
     */
    private $credentials;

    /**
     * @var RequiredProperties
     */
    private $required_properties;

    /**
     * Sendlane constructor.
     * @param null $subdomain
     * @param null $key
     * @param null $hash
     */
    public function __construct($subdomain = null, $key = null, $hash = null)
    {
        // Load required properties
        $this->required_properties = new RequiredProperties();

        // See if config values were pass during construction
        if (!empty(array_filter(get_defined_vars()))) {

            // Configure class
            $this->configure($subdomain, $key, $hash);
        }
    }

    /**
     * @param $subdomain
     * @param $key
     * @param $hash
     * @return $this
     */
    public function configure($subdomain, $key, $hash)
    {
        // Set subdomain
        $this->subdomain = $subdomain;

        // Set credentials
        $this->credentials = [
            'api' => $key,
            'hash' => $hash
        ];

        // Make sure config values are valid/not empty
        $this->validate_required_fields('credentials', $this->credentials);

        // Return self for method chaining
        return $this;
    }

    /**
     * @param $email
     * @param $password
     * @return mixed
     */
    public function user_details($email, $password)
    {
        // Set data for API call
        $data = array_filter(get_defined_vars());

        // Execute API call and return results
        return $this->call('user-details', $data);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function list_subscribers_add($data)
    {
        // Execute API call and return results
        return $this->call('list-subscribers_add', $data);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function list_subscriber_add($data)
    {
        // Execute API call and return results
        return $this->call('list-subscriber-add', $data);
    }

    /**
     * @param $email
     * @param null $list_id
     * @return mixed
     */
    public function subscribers_delete($email, $list_id = null)
    {
        // Set data for API call
        $data = array_filter(get_defined_vars());

        // Execute API call and return results
        return $this->call('subscribers-delete', $data);
    }

    /**
     * @param $email
     * @param $list_id
     * @return mixed
     */
    public function unsubscribe($email, $list_id)
    {
        // Set data for API call
        $data = array_filter(get_defined_vars());

        // Execute API call and return results
        return $this->call('unsubscribe', $data);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function list_create($data)
    {
        // Execute API call and return results
        return $this->call('list-create', $data);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function list_update($data)
    {
        // Execute API call and return results
        return $this->call('list-update', $data);
    }

    /**
     * @param $list_id
     * @return mixed
     */
    public function list_delete($list_id)
    {
        // Set data for API call
        $data = array_filter(get_defined_vars());

        // Execute API call and return results
        return $this->call('list-delete', $data);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function lists($data)
    {
        // Execute API call and return results
        return $this->call('lists', $data);
    }

    /**
     * @param $list_id
     * @return mixed
     */
    public function opt_in_form($list_id)
    {
        // Set data for API call
        $data = array_filter(get_defined_vars());

        // Execute API call and return results
        return $this->call('opt-in-form', $data);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function opt_in_create($data)
    {
        // Execute API call and return results
        return $this->call('opt-in-create', $data);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function subscriber_export($data)
    {
        // Execute API call and return results
        return $this->call('subscriber-export', $data);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function tags($data)
    {
        // Execute API call and return results
        return $this->call('tags', $data);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function tag_create($name)
    {
        // Set data for API call
        $data = array_filter(get_defined_vars());

        // Execute API call and return results
        return $this->call('tag-create', $data);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function tag_subscriber_add($data)
    {
        // Execute API call and return results
        return $this->call('tag-subscriber-add', $data);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function tag_subscriber_remove($data)
    {
        // Execute API call and return results
        return $this->call('tag-subscriber-remove', $data);
    }

    /**
     * @param $email
     * @param $list_id
     * @return mixed
     */
    public function subscriber_exists($email, $list_id)
    {
        // Set data for API call
        $data = array_filter(get_defined_vars());

        // Execute API call and return results
        return $this->call('subscriber-exists', $data);
    }

    /**
     * @param $action
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    private function call($action, $data)
    {
        // Make sure minimum required properties are present
        $this->validate_required_fields($action, $data);

        // Set API call URL
        $url = "https://{$this->subdomain}.sendlane.com/api/{$this->version}/{$action}";

        // Build POST data
        $content = http_build_query(array_merge($this->credentials, $data));

        // Set call context
        $context  = stream_context_create([
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => $content
            ]
        ]);

        // Do POST and get results
        $result = json_decode(file_get_contents($url, false, $context));

        // Make sure he have a result
        if (empty($result)) {

            // Throw bad call exception
            throw new \Exception("API call failure. Please double check configuration values.");
        }

        // See if there was an error
        if (!empty($result->error)) {

            // Loop error
            foreach ($result->error as $code => $msg) {

                // Format and store current error for exception throw
                $error_msgs[] = "[{$code}]: $msg";
            }

            // Throw error exception
            throw new \Exception(implode(', ', $error_msgs));
        }

        // See if call was successful
        if (!empty($result->success)) {

            // Return success message
            return $result->success;
        }
    }

    /**
     * @param $subdomain
     * @param $action
     * @param $data
     * @return mixed
     */
    public static function api($subdomain, $action, $data)
    {
        // Instantiate Sendlane class
        $sl = new self();

        // Set config values
        $sl->subdomain = $subdomain;
        $sl->credentials = [
            'api' => $data['key'],
            'hash' => $data['hash']
        ];

        // Execute API call and return results
        return $sl->call($action, $data);
    }

    /**
     * @param $action
     * @param $data
     * @throws \Exception
     */
    private function validate_required_fields($action, $data)
    {
        // Make sure the action is valid
        if (!isset($this->required_properties->data[$action])) {

            // Throw invalid action exception
            throw new \Exception("'{$action}' is not a valid API action/call");
        }

        // Loop properties to validate required fields
        foreach ($this->required_properties->data[$action] as $prop) {

            // See if property is empty
            if (empty($data[$prop])) {

                // Throw required property exception
                throw new \Exception("'{$prop}' is a required property for '{$action}' call");
            }
        }

        // See if config data has been set
        if (empty($this->subdomain) || empty($this->credentials)) {

            // Throw configuration exception
            throw new \Exception("API credentials or subdomain are not set. Please set during class instantiation or by using the configure() method.");
        }
    }
}