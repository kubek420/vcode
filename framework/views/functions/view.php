<?php

function view($fileName, $variables = []) {
    // Check if view file exists
    if (!file_exists(__DIR__.'/../../../app/views/'.$fileName.'.php')) {
        error('View file "'.$fileName.'" does not exist');
    }

    // Compile if view file has been modified
    //if (filemtime(__DIR__.'/../../../storage/views/'.$fileName.'.compiled.php') < filemtime(__DIR__.'/../../../app/views/'.$fileName.'.php') || !file_exists(__DIR__.'/../../../storage/views/'.$fileName.'.compiled.php')) {
    if (true) {
        // Read original page file
        $content = file_get_contents(__DIR__.'/../../../app/views/'.$fileName.'.php');

        // Variables (without escaping)
        $content = str_replace('{{{', '<?=', $content);
        $content = str_replace('}}}', '?>', $content);

        // Variables (with escaping)
        $content = str_replace('{{', '<?= htmlspecialchars(', $content);
        $content = str_replace('}}', ') ?>', $content);

        // Foreach
        $content = preg_replace('/# ?foreach ?\\((:?.*?)\\)/', '<?php foreach ($1): ?>', $content);
        $content = preg_replace('/# ?endforeach/', '<?php endforeach; ?>', $content);

        // If
        $content = preg_replace('/# ?if ?\\((:?.*?(\\(.*?\\)*)?)\\)/', '<?php if ($1): ?>', $content);
        $content = preg_replace('/# ?endif/', '<?php endif; ?>', $content);

        // Else / elseif
        $content = preg_replace('/# ?elseif ?\\((:?.*?(\\(.*?\\)*)?)\\)/', '<?php elseif ($1): ?>', $content);
        $content = preg_replace('/# ?else/', '<?php else: ?>', $content);

        // For
        $content = preg_replace('/# ?for ?\\((.*?)\\)/', '<?php for ($1): ?>', $content);
        $content = preg_replace('/# ?endfor/', '<?php endfor; ?>', $content);

        // While
        $content = preg_replace('/# ?while ?\\((.*?)\\)/', '<?php while ($1): ?>', $content);
        $content = preg_replace('/# ?endwhile/', '<?php endwhile; ?>', $content);

        // Break
        $content = preg_replace('/# ?break/', '<?php break; ?>', $content);

        // Include
        $content = preg_replace('/# ?include ?\\(\'(.*?)\'\\)/', '<?php include __DIR__."/../../app/views/$1.php"; ?>', $content);

        // Continue
        $content = preg_replace('/# ?continue/', '<?php continue; ?>', $content);

        // Logged
        $content = preg_replace('/# ?logged/', '<?php if (\WebWork\Features\LoginSystem::isLogged()): ?>', $content);
        $content = preg_replace('/# ?endlogged/', '<?php endif; ?>', $content);

        // Auth failure
        $content = preg_replace('/# ?loginerror/', '<?php if (isset($_SESSION["WEBWORK_AUTH_FAIL"])) { echo $_SESSION["WEBWORK_AUTH_FAIL"]; unset($_SESSION["WEBWORK_AUTH_FAIL"]); } else { echo ""; } ?>', $content);

        // Recaptcha
        $content = preg_replace('/# ?recaptcha/', '<?php echo \'<div class="g-recaptcha" data-sitekey="\'.captchaKey().\'"></div>\' ?>', $content);


        // Class namespaces
        $content = preg_replace('/LoginSystem::/', '\WebWork\\Features\\LoginSystem::', $content);
        $content = preg_replace('/DB::/', '\WebWork\\Features\\DB::', $content);
        $content = preg_replace('/Txt::/', '\WebWork\\Features\\Txt::', $content);
        $content = preg_replace('/Api::/', '\WebWork\\Features\\Api::', $content);
        $content = preg_replace('/Mail::/', '\WebWork\\Features\\Mail::', $content);


        // Components
        $componentFiles = array_diff(scandir(__DIR__.'/../../../app/components'), ['.', '..']);

        foreach ($componentFiles as $componentFile) {
            $componentFileContent = file_get_contents(__DIR__.'/../../../app/components/'.$componentFile);

            // Variables (without escaping)
            $componentFileContent = str_replace('{{{', '<?=', $componentFileContent);
            $componentFileContent = str_replace('}}}', '?>', $componentFileContent);
    
            // Variables (with escaping)
            $componentFileContent = str_replace('{{', '<?= htmlspecialchars(', $componentFileContent);
            $componentFileContent = str_replace('}}', ') ?>', $componentFileContent);
    
            // Foreach
            $componentFileContent = preg_replace('/# ?foreach ?\\((:?.*?)\\)/', '<?php foreach ($1): ?>', $componentFileContent);
            $componentFileContent = preg_replace('/# ?endforeach/', '<?php endforeach; ?>', $componentFileContent);
    
            // If
            $componentFileContent = preg_replace('/# ?if ?\\((:?.*?(\\(.*?\\)*)?)\\)/', '<?php if ($1): ?>', $componentFileContent);
            $componentFileContent = preg_replace('/# ?endif/', '<?php endif; ?>', $componentFileContent);
    
            // Else / elseif
            $componentFileContent = preg_replace('/# ?elseif ?\\((:?.*?(\\(.*?\\)*)?)\\)/', '<?php elseif ($1): ?>', $componentFileContent);
            $componentFileContent = preg_replace('/# ?else/', '<?php else: ?>', $componentFileContent);
    
            // For
            $componentFileContent = preg_replace('/# ?for ?\\((.*?)\\)/', '<?php for ($1): ?>', $componentFileContent);
            $componentFileContent = preg_replace('/# ?endfor/', '<?php endfor; ?>', $componentFileContent);
    
            // While
            $componentFileContent = preg_replace('/# ?while ?\\((.*?)\\)/', '<?php while ($1): ?>', $componentFileContent);
            $componentFileContent = preg_replace('/# ?endwhile/', '<?php endwhile; ?>', $componentFileContent);
    
            // Break
            $componentFileContent = preg_replace('/# ?break/', '<?php break; ?>', $componentFileContent);
    
            // Include
            $componentFileContent = preg_replace('/# ?include ?\\(\'(.*?)\'\\)/', '<?php include __DIR__."/../../app/views/$1.php"; ?>', $componentFileContent);
    
            // Continue
            $componentFileContent = preg_replace('/# ?continue/', '<?php continue; ?>', $componentFileContent);
    
            // Logged
            $componentFileContent = preg_replace('/# ?logged/', '<?php if (\WebWork\Features\LoginSystem::isLogged()): ?>', $componentFileContent);
            $componentFileContent = preg_replace('/# ?endlogged/', '<?php endif; ?>', $componentFileContent);
    
            // Auth failure
            $componentFileContent = preg_replace('/# ?loginerror/', '<?php if (isset($_SESSION["WEBWORK_AUTH_FAIL"])) { echo $_SESSION["WEBWORK_AUTH_FAIL"]; unset($_SESSION["WEBWORK_AUTH_FAIL"]); } else { echo ""; } ?>', $componentFileContent);
    
            // Recaptcha
            $componentFileContent = preg_replace('/# ?recaptcha/', '<?php echo \'<div class="g-recaptcha" data-sitekey="\'.captchaKey().\'"></div>\' ?>', $componentFileContent);
    
    
            // Class namespaces
            $componentFileContent = preg_replace('/LoginSystem::/', '\WebWork\\Features\\LoginSystem::', $componentFileContent);
            $componentFileContent = preg_replace('/DB::/', '\WebWork\\Features\\DB::', $componentFileContent);
            $componentFileContent = preg_replace('/Txt::/', '\WebWork\\Features\\Txt::', $componentFileContent);
            $componentFileContent = preg_replace('/Api::/', '\WebWork\\Features\\Api::', $componentFileContent);
            $componentFileContent = preg_replace('/Mail::/', '\WebWork\\Features\\Mail::', $componentFileContent);

            // Save compiled component
            file_put_contents(__DIR__.'/../../../storage/views/component.'.$componentFile, $componentFileContent);

            $content = preg_replace('/<'.explode('.php', $componentFile)[0].'( (.*)="(.*)")* ?\/>/', '<?php extract([\'$2\' => \'$3\', \'$4\' => \'$5\']); include __DIR__."/component.'.$componentFile.'"; ?>', $content);
        }


        // Save compiled view
        file_put_contents(__DIR__.'/../../../storage/views/'.$fileName.'.compiled.php', $content);
    }

    // Get passed variables and include compiled view
    extract($variables);
    ob_start();

    include __DIR__.'/../../../storage/views/'.$fileName.'.compiled.php';
}
