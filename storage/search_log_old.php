<?php

$logPath = "C:\\Users\\ranje\\.gemini\\antigravity\\brain\\b47d8e70-5802-4a18-9566-f641317289a9\\.system_generated\\logs\\transcript.jsonl";

if (file_exists($logPath)) {
    echo "Log file found. Searching...\n";
    $handle = fopen($logPath, "r");
    if ($handle) {
        $i = 0;
        while (($line = fgets($handle)) !== false) {
            $i++;
            if (strpos($line, "1779323940851") !== false || strpos($line, "1779323938472") !== false) {
                $obj = json_decode($line, true);
                if ($obj) {
                    echo "Line $i matches.\n";
                    echo "Type: " . ($obj['type'] ?? 'N/A') . "\n";
                    $content = $obj['content'] ?? '';
                    if ($content) {
                        // Print the first 2000 chars of content
                        echo "Content snippet:\n" . substr($content, 0, 2000) . "\n";
                    }
                    if (isset($obj['tool_calls'])) {
                        foreach ($obj['tool_calls'] as $tc) {
                            echo "Tool call: " . $tc['name'] . "\n";
                        }
                    }
                    echo "----------------------------------------\n";
                }
            }
        }
        fclose($handle);
    }
} else {
    echo "Log file not found.\n";
}
