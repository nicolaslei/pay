<?php

declare(strict_types=1);

namespace RocPay;

use RocPay\Exception\BadRequestException;
use RocPay\Exception\InvalidRequestException;

/**
 * 
 */
trait ParametersTrait
{
    /**
     * Internal storage of all of the parameters.
     *
     * @var ParameterBag
     */
    protected $parameters;

    /**
     * Set one parameter.
     *
     * @param string $key Parameter key
     * @param mixed $value Parameter value
     * @return $this
     */
    protected function setParameter($key, $value)
    {
        $this->parameters->set($key, $value);

        return $this;
    }

    /**
     * Get one parameter.
     *
     * @param  string $key Parameter key
     * @return mixed A single parameter value.
     */
    protected function getParameter($key)
    {
        return $this->parameters->get($key);
    }

    /**
     * Get all parameters.
     *
     * @return array An associative array of parameters.
     */
    public function getParameters()
    {
        return $this->parameters->all();
    }

    /**
     * Initialize the object with parameters.
     *
     * If any unknown parameters passed, they will be ignored.
     *
     * @param array $parameters An associative array of parameters
     * @return $this.
     */
    public function initialize(array $parameters = [])
    {
        $this->parameters = new class
        {
            /**
             * Parameter storage.
             */
            protected $parameters;

            public function __construct(array $parameters = [])
            {
                $this->parameters = $parameters;
            }

            /**
             * Returns the parameters.
             *
             * @param string|null $key The name of the parameter to return or null to get them all
             *
             * @return array An array of parameters
             */
            public function all(/*string $key = null*/)
            {
                $key = \func_num_args() > 0 ? func_get_arg(0) : null;

                if (null === $key) {
                    return $this->parameters;
                }

                if (!\is_array($value = $this->parameters[$key] ?? [])) {
                    throw new BadRequestException(sprintf('Unexpected value for parameter "%s": expecting "array", got "%s".', $key, get_debug_type($value)));
                }

                return $value;
            }

            /**
             * Adds parameters.
             */
            public function add(array $parameters = [])
            {
                $this->parameters = array_replace($this->parameters, $parameters);
            }

            /**
             * Returns a parameter by name.
             *
             * @param mixed $default The default value if the parameter key does not exist
             *
             * @return mixed
             */
            public function get(string $key, $default = null)
            {
                return \array_key_exists($key, $this->parameters) ? $this->parameters[$key] : $default;
            }

            /**
             * Sets a parameter by name.
             *
             * @param mixed $value The value
             */
            public function set(string $key, $value)
            {
                $this->parameters[$key] = $value;
            }

            /**
             * Removes a parameter.
             */
            public function remove(string $key)
            {
                unset($this->parameters[$key]);
            }
        };

        if ($parameters) {
            foreach ($parameters as $key => $value) {
                $method = 'set' . ucfirst(Hellper::camelCase($key));
                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
            }
        }
        return $this;
    }

    /**
     * Validate the request.
     *
     * This method is called internally by gateways to avoid wasting time with an API call
     * when the request is clearly invalid.
     *
     * @param string ... a variable length list of required parameters
     * @throws InvalidRequestException
     */
    public function validate(...$args)
    {
        foreach ($args as $key) {
            $value = $this->parameters->get($key);
            if (!isset($value)) {
                throw new InvalidRequestException("The $key parameter is required");
            }
        }
    }
}
