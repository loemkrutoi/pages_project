<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/style.css">
    <title>Project</title>
</head>
<body>
    <?php 

    require_once('../config/link.php');
    session_start();

    $i = 1;
    $j = 1;

    if ((!empty($_POST['page']) && !(empty($_POST['pageKey'])) && isset($_POST))) {
        $page = trim(mysqli_real_escape_string($link, $_POST['page']));
        $pageKeyProcess = preg_replace('/\s/', '_' , trim(mysqli_real_escape_string($link, $_POST['pageKey'])));
        if(str_contains($pageKeyProcess, '.php')) {
            $pageKey = $pageKeyProcess;
        }
        else {
            $pageKey = $pageKeyProcess. '.php';
        }
        $pageContent =
        "
        <?php require_once('../mainPages/header.php'); ?>
        <div class='container'>
        <h1>Добро пожаловать на страницу " . $page . " !</h1>
        <a href='../mainPages/admin.php'>вернуться на страницу админа</a><br>
        <a href='../mainPages/index.php'>вернуться на страницу авторизации</a>
        </div>
        ";
        $oldKey = $_POST["oldPageKey"];
        $pageId = $_POST["pageId"];
        $checkExistanceQuery = "SELECT * FROM `pages` WHERE `id_page` = '$pageId'";
        $checkExistance = $link->prepare($checkExistanceQuery);
        $checkExistance->execute();
        $resultCheckExistance = $checkExistance->get_result();

        if($resultCheckExistance->num_rows>0){
            $updateQuery = "UPDATE `pages` SET `name_page` = '$page', `key_page` = '$pageKey' WHERE `id_page` = '$pageId'";
            $update = $link->prepare($updateQuery);
            $update->execute();
            $resultUpdate = $update->get_result();  
            rename('../secondarypages/' . $oldKey, '../secondarypages/' . $pageKey);
            // file_put_contents('../secondarypages/' . $pageKey, $pageContent);
        }
        else if(!file_exists('../secondarypages/' . $pageKey)){
            $insertQuery = "INSERT INTO `pages` (`name_page`, `key_page`) VALUES ('$page' , '$pageKey')";
            $query = $link->prepare($insertQuery);
            $query->execute();
            $result = $query->get_result();
            file_put_contents($pageKey, $pageContent);
            rename($pageKey, '../secondarypages/' . $pageKey);
        }
    }

    if(isset($_GET)){
        $pageIdDel = $_GET["pageIdDel"];
        $pageLink = $_GET["pageLink"];
        $pageName = $_GET["pageName"];
        $deleteQuery = "DELETE FROM `pages` WHERE `id_page` = '$pageIdDel'";
        $del = $link->prepare($deleteQuery);
        $del->execute();
        unlink('../secondaryPages/' . $pageLink);
    }

    require_once('../mainPages/header.php');

    ?>
        <div id="insertAny" class="container col-12 vh-100 my-auto">
            <div class="insert">
                <div class="top text-center">    
                    <h1>Добро пожаловать, <?php echo $_SESSION['role'] . ' ' . $_SESSION['username']?></h1>
                    <p>Добавить новые пункты</p>
                </div>
                <div class="bottom-insert p-4 w-100 mx-auto">
                    <form class="d-flex flex-wrap justify-content-between" action="" method="POST">
                        <input hidden type="text" id="pageId" name="pageId">
                        <label for="page">Введите заголовок</label>
                        <input type="text" id="page" name="page">
                        <label for="pageKey">Введите ссылку</label>
                        <input type="text" id="pageKey" name="pageKey">
                        <input hidden type="text" id="oldPageKey" name="oldPageKey">
                        <input id="btn" type="submit" value="ДОБАВИТЬ">
                    </form>
                </div>
            </div>
        </div>

            <div id="allPages" class="container my-container vh-50 d-flex justify-content-between wrap-nowrap">
                <div class="left col-4 p-0">
                    <div class="top text-center">
                        <p>Все пункты меню</p>
                    </div>
                    <div ondragover="true" class="pagesList bottom p-2 w-100 mx-auto">
                        <?php 
                        foreach($result as $row) {
                            echo '
                            <div draggable="true" class="draggable my-page-block mt-2">
                            <form class="my-page-form" action="" method="GET">
                                <div class="number">' . $row['id_page'] . '. </div>
                                <input hidden type="text" id="updPageId" class="page-text text-center" name="pageIdDel" value="' . $row['id_page'] . '"> 
                                <input hidden type="text" id="updPageLink" class="page-text text-center" name="pageLink" value="' . $row['key_page'] . '">
                                <input hidden type="text" id="oldPageLink" class="page-text text-center" name="oldPageLink" value="' . $row['key_page'] . '">
                                <input hidden type="text" id="updPageName" class="page-text text-center" name="pageName" value="' . $row['name_page'] . '">
                                <p>' . $row['name_page'] .
                                ' | <a href=../secondarypages/' . $row['key_page'] . '>' .  $row['key_page'] . '</a></p>' .
                                '<div class="handlers">
                                    <button class="edit" id="editBtn">/</button>
                                    <input class="delete" type="submit" value="x">
                                </div>
                            </form>
                            </div>
                            ';
                            $i++;
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div id="visiblePages" class="container my-container vh-100 d-flex justify-content-between wrap-nowrap">
                <div class="right col-4 p-0">
                    <div class="top text-center">
                        <p>Видимые пункты меню</p>
                    </div>
                    <div ondragover="true" class="pagesList bottom p-2 w-100 mx-auto">
                    </div>
                </div>
            </div>
        </div>
        <?php 
        
        require_once('footer.php');
        
        ?>
        <script>
            let pageId = document.getElementById('pageId');
            let pageName = document.getElementById('page');
            let pageKey = document.getElementById('pageKey');
            let oldPageKey = document.getElementById('oldPageKey');

            let pageIdUpd = document.querySelectorAll('#updPageId');
            let pageNameUpd = document.querySelectorAll('#updPageName');
            let pageKeyUpd = document.querySelectorAll('#updPageLink');
            let oldPageKeyUpd = document.querySelectorAll('#oldPageLink');

            let editBtn = document.querySelectorAll('#editBtn');

            for(let i = 0; i < editBtn.length; i++) {
                editBtn[i].addEventListener('click', function() {
                    event.preventDefault();
                    pageId.value = pageIdUpd[i].value;
                    pageName.value = pageNameUpd[i].value;
                    pageKey.value = pageKeyUpd[i].value;
                    oldPageKey.value = oldPageKeyUpd[i].value;
                });
            }
        </script>
        <script src="../javaScript/dragAndDrop.js"></script>
</body>
</html>