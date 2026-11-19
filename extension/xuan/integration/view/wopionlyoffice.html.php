<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width" />
    <title>ONLYOFFICE Document Editor</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            -ms-content-zooming: none;
        }
        #office_frame {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: 0;
            border: none;
            display: block;
        }
    </style>
</head>
<body>
    <form id="office_form" name="office_form" target="office_frame" action="<?php echo $actionUrl; ?>" method="post">
        <input name="access_token" value="<?php echo $accessToken; ?>" type="hidden" />
        <input name="access_token_ttl" value="<?php echo $accessTokenTtl; ?>" type="hidden" />
    </form>

    <span id="frameholder"></span>

    <script type="text/javascript">
        var frameholder = document.getElementById('frameholder');
        var office_frame = document.createElement('iframe');
        office_frame.name = 'office_frame';
        office_frame.id = 'office_frame';
        office_frame.title = 'Office Frame';
        office_frame.setAttribute('allowfullscreen', 'true');
        office_frame.setAttribute('sandbox', 'allow-scripts allow-same-origin allow-forms allow-popups allow-top-navigation allow-popups-to-escape-sandbox allow-downloads allow-modals');
        office_frame.setAttribute('allow', 'autoplay camera microphone display-capture');
        frameholder.appendChild(office_frame);

        document.getElementById('office_form').submit();

        // Listen for PostMessage from OnlyOffice for navigation events
        window.addEventListener('message', function(event) {
            // Handle UI_Edit message - redirect to edit URL
            if (event.data && typeof event.data === 'object') {
                var msgId = event.data.MessageId || event.data.messageId;

                // Log all messages for debugging
                console.log('[WOPI PostMessage]', msgId, event.data);

                // Handle App_LoadingStatus - document is ready
                if (msgId === 'App_LoadingStatus') {
                    console.log('[WOPI] Document loading status:', event.data.Values ? event.data.Values.Status : 'unknown');
                }

                // Handle UI_Edit - user wants to edit (convert binary file)
                if (msgId === 'UI_Edit') {
                    console.log('[WOPI] UI_Edit received, redirecting...');
                    // The HostEditUrl should be set in CheckFileInfo response
                    // OnlyOffice will navigate to it automatically
                }

                // Handle redirect after conversion
                if (msgId === 'UI_FileVersions' || msgId === 'File_Rename') {
                    console.log('[WOPI] File version/rename event');
                }
            }
        }, false);

        // Intercept iframe navigation to handle converted file redirect
        office_frame.addEventListener('load', function() {
            try {
                var iframeUrl = office_frame.contentWindow.location.href;
                console.log('[WOPI] iframe loaded:', iframeUrl);
            } catch(e) {
                // Cross-origin, can't access iframe URL
            }
        });
    </script>
</body>
</html>
