<?php

class OfferMapper
{
    protected $partnerName;

    protected $queriedPartner;

    public function __construct()
    {
        $this->setQueriedPartner();
        $this->setPartner();
        $this->registerOptionsPage();
        $this->registerPartnerNameShortcode();
    }

    private function setQueriedPartner()
    {
        $this->queriedPartner = $_GET['partner'] ?? null;
    }

    private function getPartnerFromMapper()
    {
        if (!$this->queriedPartner) return;

        $fields = get_field('offer_mapper', 'option');

        $matchedPartner = array_find($fields, function ($item) {
            return $item['slug'] === $this->queriedPartner;
        });

        if ($matchedPartner) {
            return $matchedPartner['name'];
        }

        $this->sendPartnerNotFoundNotification();
        return '';
    }

    private function sendPartnerNotFoundNotification()
    {
        // $api_url = 'https://hooks.slack.com/services/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'; // investoo
        // $channel = 'notification-development'; // investoo

        $api_url = 'https://hooks.slack.com/services/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';
        $channel = 'notify-lp-errors';

        $request_args = [
            'method' => 'POST',
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                'channel' => $channel,
                'blocks' => [
                    [
                        'type' => 'section',
                        'text' => [
                            'type' => 'mrkdwn',
                            'text' => "@here Adgroup ID not found in mapper: *{$this->queriedPartner}*",
                        ]
                    ],
                ],
            ]),
        ];

        wp_remote_request($api_url, $request_args);
    }

    private function setPartner()
    {
        $this->partnerName = $this->getPartnerFromMapper();
    }

    private function registerPartnerNameShortcode()
    {
        add_shortcode('partner-name', function ($attrs) {
            return $this->partnerName;
        });
    }

    private function registerOptionsPage()
    {
        acf_add_options_page([
            'page_title' => 'Offer Mapper',
            'menu_title' => 'Offer Mapper',
            'menu_slug' => 'offer-mapper',
            'capability' => 'manage_options'
        ]);
    }
}
