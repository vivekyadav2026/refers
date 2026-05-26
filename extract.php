<?php
$lines = file('C:\Users\ranje\.gemini\antigravity\brain\e1066a08-ee91-4719-8d1f-220ba93a9634\.system_generated\logs\transcript.jsonl');
foreach($lines as $line) {
    $data = json_decode($line, true);
    if(isset($data['type']) && $data['type'] == 'USER_INPUT') {
        file_put_contents('user_list.txt', $data['content']);
        break;
    }
}
echo "Done.";
