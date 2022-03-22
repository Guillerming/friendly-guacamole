<html>

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <base href="<?php echo $fg->SETTINGS['base_url']; ?>" />

        <link type="text/css" rel="stylesheet" href="assets/css/styles.css" />
        <script type="text/javascript" src="assets/js/main.js"></script>

        <title>My first FriendlyGuacamole app - Public Layout</title>
    </head>
    <body data-version="<?php echo $fg->SETTINGS['version']; ?>">

        <?php echo $fg->html('COMPONENT_HEADER'); ?>

        {{layout-pointer.main}}

        <?php echo $fg->html('COMPONENT_FOOTER'); ?>

    </body>

</html>