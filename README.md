# Domain Authenticator Manager

<p>By this domain authenticator server anyone can add domain automaton on their code, it's very simple and easy to use this domain authenticator server,&nbsp;</p>
<p>&nbsp;</p>
<p><strong>How to Install ?</strong></p>
<ol>
<li>Clone the repogetory</li>
<li>uplaod on your server&nbsp;</li>
<li>create MySql database and user&nbsp;</li>
<li>Import the <strong>database.sql&nbsp;</strong></li>
<li>Put the database credential on <strong>config.php</strong></li>
</ol>
<p><strong>Now you are ready to login into the domain control panel&nbsp;</strong></p>
<p>https://example.com/login.php</p>
<p>user:-&nbsp;admin</p>
<p>password:-&nbsp;admin</p>




# You can use our WordPress theme function code on any Theme

```
function check_domain_allowed_theme() {
    $api_url = 'https://active.devtool.my.id/admin/api.php?nonce=' . md5(uniqid(rand(), true)); // Append a unique query parameter to bypass caching
    $response = wp_remote_get($api_url);

    if (is_wp_error($response)) {
        return; // If API call fails, do nothing
    }

    $body = wp_remote_retrieve_body($response);
    $api_response = json_decode($body, true); // Decoding JSON as associative array

    // Extracting the domain from the $_SERVER['HTTP_HOST']
    $current_domain = $_SERVER['HTTP_HOST'];

    foreach ($api_response as $item) {
        if ($item['domain'] == $current_domain) {
            // Check if the domain is active or not
            if ($item['active'] == 1) {
                return; // Domain is active, allow access
            } else {
                // If the domain is not active, show the message
                echo '<p style="color:red;font-size:30px;font-weight:600;text-align:center;">' . esc_html($item['message']) . '</p>';
                exit; // Stop further execution
            }
        }
    }

    // If the domain is not found in the API response, show the default message
    echo '<p style="color:red;font-size:30px;font-weight:600;text-align:center;">You are not allowed to use this code</p>';
    exit; // Stop further execution
}
add_action('wp_head', 'check_domain_allowed_theme');

```
