<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iMono</title>

    <!-- icone -->
    <link rel="shortcut icon" type="image/x-icon" href="app/views/assets/images/imono_icon.png" />

    <style>
        @import url('https://fonts.cdnfonts.com/css/poppins');

        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #ebebeb;
            min-height: 100vh;
            margin: 0;
            overflow-y: hidden;
        }

        .container {
            margin: 50px;
        }

        .logo {
            font-size: 48px;
            font-weight: bold;
            color: #5e17eb;
        }

        .content {
            background-color: #fff;
            padding: 25px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">iMono</div>
        <div class="content">
            <p>
                An open-source PHP monolithic framework for efficient web development. Organized structure, simplicity,
                and
                powerful features for agile apps.
            </p>

            <ul>
                <li>
                    Http host: <b><?= $host ?></b>
                </li>

                <li>
                    Current date time: <b id="currentDateTime"></b>
                </li>
            </ul>
        </div>
    </div>

    <script>
        const data = {};

        const requestOptions = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        };

        fetch('api/getCurrentDateTime', requestOptions)
            .then(response => response.json())
            .then(responseData => {
                console.log(responseData);

                let data = responseData["data"];
                let current_date_time = data["current_date_time"];

                document.getElementById("currentDateTime").textContent = current_date_time;
            })
            .catch(error => {
                console.error('There was an error: ' + error);
            });
    </script>
</body>

</html>