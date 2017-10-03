<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Teste de upload</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type='text/javascript' src='{url}assets/js/bootstrap-filestyle.min.js'></script>
    <script type='text/javascript' src='{url}assets/js/jquery-form.js'></script>    
</head>
<body>
    <div class='container'>
        <div class='col-md-6'>
            <form id='form1' action="{url}teste/singlefile" method="post" enctype="multipart/form-data">
                <label for="file1">Single File</label>
                <input type="file" name="myfile1" id="file1" data-text="Select single file"><br />
                <button type="submit" class="btn btn-primary">Enviar single file </button>
            </form>
        </div>

        <div class='col-md-6'>
            <form id='form2' action="{url}teste/multiplefiles" method="post" enctype="multipart/form-data">
                <label for="file2">Multiple Files</label>
                <input type="file" name="myfile2[]" id="file2" multiple data-text="Select multiple files"><br />
                <button type="submit" class="btn btn-primary">Enviar multiple files</button>
            </form>
        </div>
    </div>
    <script type='text/javascript' src='{url}assets/js/common.js'></script>
</body>
</html>