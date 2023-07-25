<style>
    .avatarMessage {
        width: 42px;
        height: 42px;
        object-fit: cover;
        object-position: center;
        border-radius: 50%;
    }

    main h1 {
        display: none;
    }

    #messages-body {
        overflow-y: scroll;
    }

    #container-main {
        padding-top: 20px !important;
        padding-bottom: 20px !important;
    }

    main {
        min-height: 85.2vh !important;
    }
</style>
<div class="card" style="height: 80vh!important;">
    <div class="card-header">
        <div class="row justify-content-between align-items-center">
            <div class="col-3">
                <a href="<?= $_SERVER["HTTP_REFERER"] ?>">back</a>
            </div>
            <div class="col-4 text-center">
                <?= $userMessage["login"] ?>
            </div>
            <div class="col-3 text-end">
                <img class="avatarMessage" src="../../../img/avatars/<?= $userMessage["avatar_name"] ?>" alt="av">
            </div>
        </div>
    </div>
    <div class="card-body d-flex flex-column justify-content-end" id="messages-body">
        <!-- messages place -->
    </div>
    <div class="card-footer">
        <form method="POST" class="my-2" id="sendMessage" action="your-page.php" onsubmit="onFormSubmit();">
            <div class="input-group">
                <!-- <textarea type="text" name="mess" minlength="1" class="form-control py-2" rows="1" placeholder="write you message here" required></textarea> -->
                <input type="text" name="message" minlength="1" class="form-control py-2" placeholder="write you message here" required>
                <input class="btn btn-success" id="submitButton" type="submit" value="SEND">
            </div>
        </form>
    </div>
</div>

<script>
    // getMessages -------------------------------------------------
    const blockCardBody = document.getElementById("messages-body");
    let countScroll = 0;
    let oldCountMess = null;
    async function getContent() {
        const formData = new FormData();
        formData.append('confirm', 'true');
        formData.append('idUserMessage', <?= $idUserMessage ?>);
        try {
            const response = await fetch("/messenger/get-messages", {
                method: "POST",
                body: formData
            });
            const result = await response.json();
            blockCardBody.innerHTML = result;
            if (!countScroll) {
                scrollDownMessages();
                countScroll++;
                oldCountMess = blockCardBody.children.length;
            }
            if (blockCardBody.children.length > oldCountMess) {
                scrollDownMessages();
                oldCountMess = blockCardBody.children.length;
            }
        } catch (error) {
            console.error(`Download error: ${error.message}`);
        }
    }

    function scrollDownMessages() {
        blockCardBody.scrollTo(0, blockCardBody.scrollHeight);
    }
    getContent();

    setInterval(() => {
        getContent();
    }, 1000);

    // sendMessages -------------------------------------------------

    const form = document.getElementById("sendMessage");

    async function onFormSubmit(){
        event.preventDefault();

        if (form["message"].value.length > 0) {
            const formData = new FormData();
            formData.append('confirm', 'true');
            formData.append('idUserMessage', <?= $idUserMessage ?>);
            formData.append('message', form["message"].value);
            formData.append('loginUserMessage', "<?= $loginUserMessage ?>");

            try {
                const response = await fetch("/messenger/send-message", {
                    method: "POST",
                    body: formData
                });
                const result = await response.json();
                if (result === "success") {
                    form["message"].value = "";
                } else {
                    console.log(result);
                }
            } catch (error) {
                console.error(`Error send-message: ${error.message}`);
            }
        }

    }
</script>