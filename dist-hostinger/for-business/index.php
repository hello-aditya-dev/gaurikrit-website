<?php
// V47: Partners merged into Contact. Permanent redirect.
http_response_code(301);
header('Location: /contact/', true, 301);
exit;
