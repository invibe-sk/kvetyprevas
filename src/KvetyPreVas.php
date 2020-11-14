<?php


namespace Invibe\KvetyPreVas;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;

/**
 * Class KvetyPreVas
 * @author Adam Ondrejkovic
 * @package App\Services
 */
class KvetyPreVas
{
    private $client;

    /**
     * KvetyPreVas constructor.
     */
    public function __construct()
    {
        $options = [
            'base_uri' => config('kvetyprevas.api_url'),
            'headers' => [
                'Content-Type' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest',
                'api-key' => config('kvetyprevas.api_key'),
            ],
            'connect_timeout' => false,
            'timeout' => 30.0,
            'verify' => false,
        ];

        if (!app()->environment('production')) {
            $options['verify'] = false;
        }

        $this->client = new Client($options);
    }

    /**
     * @return mixed
     * @throws GuzzleException
     * @author Adam Ondrejkovic
     */
    public function categories()
    {
        $response = $this->client->get("categories");

        $response = json_decode($response->getBody());

        return $response;
    }

    /**
     * @param string $slug
     * @return mixed
     * @throws GuzzleException
     * @author Adam Ondrejkovic
     */
    public function category(string $slug)
    {
        $response = $this->client->get("categories/$slug");

        $response = json_decode($response->getBody());

        return $response;
    }

    /**
     * @param string $slug
     * @param Request $request
     * @return mixed
     * @throws GuzzleException
     * @author Adam Ondrejkovic
     */
    public function categoryProducts(string $slug, Request $request)
    {
        $response = $this->client->get("categories/$slug/products", [RequestOptions::BODY => json_encode($request->only(['order', 'page', 'price-to']))]);

        $response = json_decode($response->getBody());

        return $response;
    }

    /**
     * @param string $slug
     * @return mixed
     * @throws GuzzleException
     * @author Adam Ondrejkovic
     */
    public function product(string $slug)
    {
        $response = $this->client->get("products/$slug");

        $response = json_decode($response->getBody());

        return $response;
    }

    /**
     * @param string $slug
     * @param int|null $limit
     * @return mixed
     * @throws GuzzleException
     * @author Adam Ondrejkovic
     */
    public function related(string $slug, int $limit = null)
    {
        $response = $this->client->get("products/$slug/related", [RequestOptions::BODY => json_encode(compact('limit'))]);

        $response = json_decode($response->getBody());

        return $response;
    }

    /**
     * @param int $limit
     * @return mixed
     * @throws GuzzleException
     * @author Adam Ondrejkovic
     */
    public function topProducts($limit = 10)
    {
        $data = [
            'limit' => $limit
        ];

        $response = $this->client->get("products/top", [RequestOptions::BODY => json_encode($data)]);

        $response = json_decode($response->getBody());

        return $response;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws GuzzleException
     * @author Adam Ondrejkovic
     */
    public function deliveryPrice(array $data)
    {
        $response = $this->client->post("orders/get-delivery-price", [RequestOptions::FORM_PARAMS => $data]);

        $response = json_decode($response->getBody());

        return $response;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws GuzzleException
     * @author Adam Ondrejkovic
     */
    public function earlyDiscount(array $data)
    {
        $response = $this->client->post("orders/get-early-discount", [RequestOptions::FORM_PARAMS => $data]);

        $response = json_decode($response->getBody());

        return $response;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws GuzzleException
     * @author Adam Ondrejkovic
     */
    public function validateDateAndTime(array $data)
    {
        $response = $this->client->post("orders/validate-date-and-time", [RequestOptions::FORM_PARAMS => $data]);

        $response = json_decode($response->getBody());

        return $response;
    }

    /**
     * @return mixed
     * @throws GuzzleException
     * @author Adam Ondrejkovic
     */
    public function paymentMethods()
    {
        $response = $this->client->get("payment-methods");

        $response = json_decode($response->getBody());

        return $response;
    }

    /**
     * @return mixed
     * @throws GuzzleException
     * @author Adam Ondrejkovic
     */
    public function deliveryOptions()
    {
        $response = $this->client->get("delivery-options");

        $response = json_decode($response->getBody());

        return $response;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws GuzzleException
     * @author Adam Ondrejkovic
     */
    public function placeOrder(array $data)
    {
        $response = $this->client->post("orders/place", [RequestOptions::FORM_PARAMS => $data]);

        $response = json_decode($response->getBody());

        return $response;
    }

    /**
     * @param string $number
     * @param string $viewToken
     * @return mixed
     * @throws GuzzleException
     * @author Adam Ondrejkovic
     */
    public function viewOrder(string $number, string $viewToken)
    {
        $response = $this->client->get("orders/view", [
            RequestOptions::HEADERS => ['view-token' => $viewToken],
            RequestOptions::BODY => json_encode(['number' => $number])
        ]);

        $response = json_decode($response->getBody());

        return $response;
    }

    /**
     * @return mixed
     * @throws GuzzleException
     * @author Adam Ondrejkovic
     */
    public function reorderOptions()
    {
        $response = $this->client->get("products/reorder-options");

        $response = json_decode($response->getBody(), true);

        return $response;
    }

    /**
     * @return mixed
     * @throws GuzzleException
     * @author Adam Ondrejkovic
     */
    public function priceToOptions()
    {
        $response = $this->client->get("products/price-to-options");

        $response = json_decode($response->getBody());

        return $response;
    }

    /**
     * @param string|null $email
     * @return mixed
     * @throws GuzzleException
     * @author Adam Ondrejkovic
     */
    public function newsletterSubscribe(string $email = null)
    {
        $response = $this->client->post("newsletter/subscribe", [RequestOptions::FORM_PARAMS => compact('email')]);

        $response = json_decode($response->getBody(), true);

        return $response;
    }

    /**
     * @param $data
     * @return mixed
     * @throws GuzzleException
     * @author Adam Ondrejkovic
     */
    public function paypalState($data)
    {
        $response = $this->client->post("orders/paypal/state", [RequestOptions::FORM_PARAMS => $data]);

        $response = json_decode($response->getBody());

        return $response;
    }

    /**
     * @param $data
     * @return mixed
     * @throws GuzzleException
     * @author Adam Ondrejkovic
     */
    public function barionState($data)
    {
        $response = $this->client->post("orders/barion/process", [RequestOptions::FORM_PARAMS => $data]);

        $response = json_decode($response->getBody());

        return $response;
    }

    /**
     * @param string $orderId
     * @return mixed
     * @throws GuzzleException
     * @author Adam Ondrejkovic
     */
    public function getOrder(string $orderId)
    {
        $response = $this->client->get("orders/get", [RequestOptions::BODY => json_encode(['id' => $orderId])]);

        $response = json_decode($response->getBody(), true);

        return $response;
    }

    /**
     * @param string $search
     * @return mixed
     * @throws GuzzleException
     * @author Adam Ondrejkovic
     */
    public function search($search)
    {
        $response = $this->client->get("products/search", [RequestOptions::BODY => json_encode(['query' => $search])]);

        $response = json_decode($response->getBody());

        return $response;
    }
}
