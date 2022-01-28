<html>

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link type="text/css" rel="stylesheet" href="assets/css/styles.css" />
        <script type="text/javascript" src="assets/js/main.js"></script>

        <title>My first FriendlyGuacamole app - Public Layout</title>
    </head>
    <body>

        <?php echo $friendlyGuacamole->ComponentsModule->html('COMPONENT_HEADER'); ?>

        {{layout-pointer.main}}

        <?php echo $friendlyGuacamole->ComponentsModule->html('COMPONENT_FOOTER'); ?>

    </body>

</html>