%if mode == 'definition':
Balanced\APIKey::get()

% else:
<?php

require(__DIR__ . '/vendor/autoload.php');

Httpful\Bootstrap::init();
RESTful\Bootstrap::init();
Balanced\Bootstrap::init();

Balanced\Settings::$api_key = "ak-test-2eKlj1ZDfAcZSARMf3NMhBHywDej0avSY";

Balanced\APIKey::get("/api_keys/AK3DQGzROuoRYulKXMQdHBxX")

?>
%endif