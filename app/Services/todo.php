public function sync_domains($id){
        $googleAccount = $this->module_model->getGoogleAccount($id);
        $client = new Google_Client();
        $client->setClientId($this->clientId);
        $client->setScopes([Google_Service_Webmasters::WEBMASTERS_READONLY, Google_Service_Oauth2::USERINFO_EMAIL, Google_Service_Oauth2::USERINFO_PROFILE]);
        $client->setClientSecret($this->clientSecret);
        $client->setRedirectUri('https://brain.vonteq.ro/admin/seo_tehnic_admin/callback');
        $token = json_decode($googleAccount[0]['access_token']);
        if ($token) {
            $client->setAccessToken($token);
        } else {
            $client->setAccessToken(json_decode($googleAccount[0]['refresh_token']));
        }
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken(json_decode($googleAccount[0]['refresh_token']));
            $token = $client->getAccessToken();
            $this->module_model->updateToken($id, $token['access_token']);
        }
        $webmastersService = new Google_Service_Webmasters($client);
        $sites = $webmastersService->sites->listSites();
        $domains = $this->formatDomains($sites->getSiteEntry());
        $this->module_model->updateDomains($id, $domains);
        $this->sync_properties($id, json_decode($googleAccount[0]['refresh_token']));
        redirect(admin_url('seo_tehnic_admin'));
    }

    public function get_google_data() {
        $this->load->model('projects_model');
        $websiteGoogleEmailAddress = $this->projects_model->get_google_console_email($this->input->post('project_id'));
        if ($websiteGoogleEmailAddress) {
            $googleAccountData = $this->module_model->get($websiteGoogleEmailAddress);
            $token = json_decode($googleAccountData[0]['access_token']);
            $client = $this->init_client($token, json_decode($googleAccountData[0]['refresh_token']));
            $webmastersService = new Google_Service_Webmasters($client);
            $projectData = $this->projects_model->get($this->input->post('project_id'));
            $query = new Google_Service_Webmasters_SearchAnalyticsQueryRequest();
            $query->setStartDate($projectData->start_date);
            $query->setEndDate(date('Y-m-d'));
            $query->setDimensions(['query', 'page']);
            $query->setSearchType('web');

            // $domains = $googleAccountData[0]['domains'];
            // $domains = json_decode($domains);
            $siteUrl = $projectData->google_domain;
            // var_dump($siteUrl);die;
            // $siteUrl = $this->format_site_url($projectData->name);
            // foreach ($domains as $domain) {
            //     if (str_contains(strtolower($domain), strtolower($projectData->name))) {
            //         $siteUrl = $domain;
            //         break;
            //     }
            // }
            try {
                $response = $webmastersService->searchanalytics->query($siteUrl, $query);
            } catch (Google_Service_Exception $e) {
                echo json_encode(['error' => 'An error occurred: ' . htmlspecialchars($e->getMessage())]);
                die;
            }
            $data = [];
            $rows = $response->getRows();
            // if (!empty($rows)) {
            //     foreach ($rows as $row) {
            //         $data[] = [
            //             'Keyword' => $row->getKeys()[0],
            //             'Position' => round($row->getPosition(), 2),
            //             'Impressions' => $row->getImpressions(),
            //             'Clicks' => $row->getClicks(),
            //             'URL' => $row->getKeys()[1],
            //             'Country' => $row->getKeys()[2],
            //             'Date' => $row->getKeys()[3],
            //         ];
            //     }
            // }
            if (!empty($rows)) {
                foreach ($rows as $row) {
                    $keyword = $row->getKeys()[0];
                    if (!isset($data[$keyword])) {
                        $data[$keyword] = [
                            'Clicks' => 0,
                            'Impressions' => 0,
                            'Position' => 0,
                            'URL' => $row->getKeys()[1],
                        ];
                    }
                    $data[$keyword]['Clicks'] += $row->getClicks();
                    $data[$keyword]['Impressions'] += $row->getImpressions();
                    $data[$keyword]['Position'] += round($row->getPosition(), 2);
                }
            }
            // var_dump($data);die;
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'No google account found']);
        }
    }

    private function formatDomains($domains){
        $domainsArray = [];
        foreach ($domains as $domain) {
            $domainsArray[] = $domain->siteUrl;
        }

        return $domainsArray;
    }