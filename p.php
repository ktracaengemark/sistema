<html>
    <head>
        <title>JQUERY</title>
        <script src="js/jquery.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap.css">

        <script type="text/javascript">
            /*
            $(document).ready(function () {
                $(':button').click(function () {

                    /*$('img').css({
                     width: '500px',
                     height: '50px',
                     border: '2px solid green'
                     })
                    $('img').addClass('css');
                })
            });
            */
        </script>

    </head>
    <body>

        <br>

        <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default active">
                <input type="radio" name="options" id="option1" autocomplete="off"> Agendada
            </label>
            <label class="btn btn-default">
                <input type="radio" name="options" id="option2" autocomplete="off"> Confirmada
            </label>
            <label class="btn btn-default">
                <input type="radio" name="options" id="option3" autocomplete="off"> Compareceu
            </label>
            <label class="btn btn-default">
                <input type="radio" name="options" id="option4" autocomplete="off"> Faltou
            </label>
            <label class="btn btn-default">
                <input type="radio" name="options" id="option5" autocomplete="off"> Remarcada
            </label>
            <label class="btn btn-default">
                <input type="radio" name="options" id="option6" autocomplete="off"> Cancelada
            </label>    
        </div>     

        <br><br>

        <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-primary active">
                <input type="radio" name="options" id="option1" autocomplete="off" checked> Radio 1
            </label>
            <label class="btn btn-primary">
                <input type="radio" name="options" id="option2" autocomplete="off"> Radio 2
            </label>
            <label class="btn btn-primary">
                <input type="radio" name="options" id="option3" autocomplete="off"> Radio 3
            </label>
        </div>

    </body>
</html>
