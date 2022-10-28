<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,viewport-fit=cover">
    <title>查询</title>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://admui.bangbangda.me/public/vendor/jquery/jquery.min.js"></script>

    <script type="text/javascript">
        function search() {
            axios.post('/search', {
                'search_key': document.getElementById('search_key').value,
            }).then(function (response) {
                if (response.data.data.length == 0) {
                    $("#no-result").show();
                } else {
                    $("#correct_answer").html(response.data.data[0].correct_answer);
                    $("#type").html(response.data.data[0].type);
                    $("#content").html(response.data.data[0].content);
                    $("#result").show();
                }
            });
        }
    </script>
    <style >
        .form-control {
            box-sizing: border-box;
            height: 2.287rem;
            width: 80%;
            font-weight: 400;
            border-color: #e4eaec;
            box-shadow: none;
            -webkit-transition: box-shadow 0.25s linear, border 0.25s linear, color 0.25s linear,
            background-color 0.25s linear;
            transition: box-shadow 0.25s linear, border 0.25s linear, color 0.25s linear,
            background-color 0.25s linear;
            -webkit-appearance: none;
            -moz-appearance: none;
            text-rendering: auto;
            -webkit-font-smoothing: auto;
            border-radius:200px;
        }
        .btn {
            cursor: pointer;
            padding: 8px 0;
            width: 18%;
            -webkit-transition: border 0.2s linear, color 0.2s linear, width 0.2s linear,
            background-color 0.2s linear;
            transition: border 0.2s linear, color 0.2s linear, width 0.2s linear,
            background-color 0.2s linear;
            -webkit-font-smoothing: subpixel-antialiased; }

        .btn-block {
            white-space: normal;

        }
        .btn-primary {
            color: #fff;
            background-color: #3e8ef7;
            border-color: #3e8ef7;
            box-shadow: none; }
    </style>
</head>
<body>
    <div>
        <input name="search_key" id="search_key" class="form-control">
        <button class="btn btn-block btn-primary" type="button" onclick="search();">检索</button>
    </div>

    <div id="no-result" style="display: none">
        <h1>未查询到指定的考题</h1>
    </div>

    <div id="result" style="display: none">
        <h1 id="correct_answer"></h1>
        <h3 id="type"></h3> <h3 id="content"></h3>
    </div>
</body>
</html>