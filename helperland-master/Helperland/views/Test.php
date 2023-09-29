<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;500;600;700&display=swap');
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Nunito', sans-serif;        
        }

        body {
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            scroll-behavior: smooth;
            position: relative;
        }

        .btn{
            box-shadow:none;
        }
        a {
            text-decoration: none !important;
        }
    </style>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <div class="container py-4 d-flex flex-column">
        <h1 class='text-center'>CSRF-TOKEN PAGE</h1>

        <h5 class='text-center py-3' id='token'><?= csrfToken(); ?></h5>

        <button id='getNewTokenBtn' class='btn btn-primary mt-5 mx-auto' style='width:200px;'>
            <h5 class='m-0'>Get New Token</h5>
        </button>
    </div>


    <script>
        let csrfToken = ``;
        $.ajaxSetup({
            beforeSend : function(req){
                getToken();
                req.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                console.log(csrfToken);
            }
        });

        function getToken(){
            let cookie = document.cookie.split(';');
            let arr = [];
            cookie = cookie.map((i)=> {
                arr = [];
                key = i.split('=')[0].trim();
                value = i.split('=')[1].trim();
                arr[key]=value;
                return arr;
            });
            let filtered = cookie.filter((i)=> {
                return i['X-CSRF-TOKEN'];
            } );
            csrfToken = filtered[0]['X-CSRF-TOKEN'];
            return filtered[0]['X-CSRF-TOKEN'];
        }

        $('#getNewTokenBtn').click(()=>{
            let BASE_URL = `<?= BASE_URL ?>`;
            $.ajax({
                url : `${BASE_URL}/test/set-token`,
                method : 'POST',
                success : function(res){
                    document.getElementById('token').innerHTML = csrfToken;
                }
            })
        });
    </script>
</body>
</html>

