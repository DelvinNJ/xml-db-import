<html lang="">

<head>
    <script src="https://kit.fontawesome.com/b078cd548f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./app.css">
    <title>Navigation Menu</title>
</head>

<body>
    <div class="menu">
        <ul class="list">
            <li class="item">
                <a target="_blank"
                    href="https://github.com/DelvinNJ/xml-db-import/blob/log-file-operation/README.md#running-unit-tests">
                    <span class="icon">
                        <i class="	fa fa-terminal"></i>
                    </span>
                    <span class="text">
                        CMD
                    </span>
                </a>
            </li>
            <li class="item">
                <a href="{{ url('api/documentation') }}">
                    <span class="icon">
                        <i class="fa fa-map-signs"></i>
                    </span>
                    <span class="text">
                        API
                    </span>
                </a>
            </li>
            <li class="item">
                <a href="{{ url('log-viewer') }}">
                    <span class="icon">
                        <i class="fa fa-warning"></i>
                    </span>
                    <span class="text">
                        Log
                    </span>
                </a>
            </li>
            <div class="ind"></div>
        </ul>
        <div>
            <code>

            </code>
        </div>
    </div>
</body>

</html>
