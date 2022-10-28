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
            $("#no-result").hide();
            $("#list").html("");

            axios.post('/search', {
                'search_key': document.getElementById('search_key').value,
            }).then(function (response) {
                if (response.data.data.length == 0) {
                    $("#no-result").show();
                } else {
                    response.data.data.forEach(function (value) {
                        $("#list").append('' +
                            '<div class="pricing-list">' +
                            '    <div class="pricing-header">' +
                            '        <div class="pricing-title">'+value.type+'</div>' +
                            '        <div class="pricing-price">' +
                            '            <span class="pricing-amount">'+value.correct_answer+'</span>' +
                            '        </div>' +
                            '    </div>' +
                            '    <ul class="pricing-features">' +
                            '        <li>' +
                            '            <strong>'+value.content+'</strong>' +
                            '        </li>' +
                            '    </ul>' +
                            '</div>' +
                            '');
                    })
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
        .pricing-list {
            margin-bottom: 22px;
            text-align: center;
            border: 1px solid #e4eaec;
            border-radius: 0.215rem; }
        .pricing-list [class^="bg-"],
        .pricing-list [class^="bg-"] *,
        .pricing-list [class*="bg-"],
        .pricing-list [class*="bg-"] * {
            color: #fff; }
        .pricing-list .pricing-header {
            border-bottom: 1px solid #e4eaec;
            border-radius: 0.215rem 0.215rem 0 0; }
        .pricing-list .pricing-title {
            background-color: #ff4c52 !important;
            padding: 15px 30px;
            color: white;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-radius: 0.215rem 0.215rem 0 0; }
        .pricing-list .pricing-price {
            padding: 20px 30px;
            margin: 0;
            font-size: 2.358rem;
            font-weight: 700;
            color: #37474f; }
        .pricing-list .pricing-period {
            font-size: 1rem;
            font-weight: 400; }
        .pricing-list .pricing-features {
            padding: 0 18px;
            margin: 0; }
        .pricing-list .pricing-features li {
            display: block;
            padding: 15px;
            list-style: none;
            border-top: 1px dashed #e4eaec; }
        .pricing-list .pricing-features li:first-child {
            border-top: none; }
        .pricing-list .pricing-footer {
            padding: 30px;
            border-radius: 0 0 0.215rem 0.215rem; }
    </style>
</head>
<body>
    <div style="margin-bottom: 15px;">
        <input name="search_key" id="search_key" class="form-control">
        <button class="btn btn-block btn-primary" type="button" onclick="search();">检索</button>
    </div>

    <div id="no-result" style="display: none">
        <h1>未查询到指定的考题</h1>
    </div>
    <div id="list"></div>
</body>
</html>