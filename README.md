# Domain Authenticator Manager

<p> With this domain authenticator server, anyone can add domain authentication to their code, it's very simple and easy to use this domain authenticator server. The primary purpose of this project is to help those freelancers who got cheated by clients after completing the project </p>
<p>&nbsp;</p>

<h3>Highlighted Features : </h3>
<ul>
    <li>Easy to use</li>
    <li>Simple & fast loading Admin panel</li>
    <li>Show any text message from the admin panel</li>
    <li>It can delete the entire website in one command</li>
    <li>Prebuild WP theme function code and plugin </li>
</ul><br><br>

<h3>Requirements :</h3>
<ul>
    <li>PHP >= 8.1</li>
    <li>MySql Database</li>
</ul><br><br>

<p><strong>How to Install ?</strong></p>
<ol>
    <li>Clone the repogetory</li>
    <li>uplaod on your server&nbsp;</li>
    <li><a href="https://active.devtool.my.id"><strong>Register</strong></a> your domain</li>
    <li>Create MySql database and user&nbsp;</li>
    <li><a href="https://active.devtool.my.id/checker.php"><strong>Downlaod</strong></a> the database</li>
    <li>Import the <strong>database.sql&nbsp;</strong></li>
    <li>Put the database credential on <strong>config.php</strong></li>
</ol>

<p><strong>Now you are ready to login into the domain control panel&nbsp;</strong></p>
<p>https://example.com/login.php</p>
<p>user:- admin</p>
<p>password:- admin</p>
<br>


<p>WordPress users can use our WordPress theme function code on any theme. also, we have a WordPress <a href="https://github.com/websmartbd/Domain-Validator-Plugin" rel="dofollow" >Plugin</a> to validate the authorized domain</p>
<br>
<p><b>Note:- If you don't have a good knowledge of PHP code or theme function we recommend using the Plugin instead of function code </b></p>

```

function check_domain_allowed_theme() {
    $api_url = 'https://example.com/api.php?nonce=' . md5(uniqid(rand(), true)); // Append a unique query parameter to bypass caching
    $response = wp_remote_get($api_url);

    if (is_wp_error($response)) {
        return; // If the API call fails, do nothing
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
