<html>

    <head>
        <title>My first FriendlyGuacamole app - Public Layout</title>
        <link type="text/css" rel="stylesheet" href="assets/css/styles.css" />
    </head>
    <body>

        <?php echo $friendlyGuacamole->ComponentsModule->html('COMPONENT_HEADER'); ?>

        {{layout-pointer.main}}

        <?php echo $friendlyGuacamole->ComponentsModule->html('COMPONENT_FOOTER'); ?>

    </body>

</html>