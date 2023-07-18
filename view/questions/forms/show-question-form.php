<div class="">
    <?php if ($question["login"] === $_SESSION["login"]) : ?>
        <p class="m-4 mb-0 text-warning-emphasis"><small>Your Question: </small></p>
    <?php else : ?>
        <p class="m-4 mb-0 text-warning-emphasis"><small>Question from customer: "<a href="/profile/<?= $question["login"] ?>"><?= $question["login"] ?></a>"</small></p>
    <?php endif; ?>
    <hr class="border border-secondary border-1 opacity-50">
    <h5 class="m-4">Content: </h5>
    <div class="d-flex">
        <div class="vr" style="width: 2px;"></div>
        <p class="m-2 mx-4"><?= nl2br($question["content"]) ?></p>
    </div>
    <p class="m-4 text-warning-emphasis"><small>Time: <?= str_replace(["-", " "], [".", " - "], $question["creationTime"]) ?></small></p>
    <?php if ($question["login"] === $_SESSION["login"] or $_SESSION["status"] === "moderator" or $_SESSION["status"] === "admin") : ?>
        <a class="text-danger" href="/delete/questions/<?= $question['id'] ?>">Delete Question</a>
    <?php endif; ?>

    <hr class="border border-secondary border-1 opacity-50">

    <?php if ($countAnswers > 0) : ?>
        <h5 class="m-4"><?= $countAnswers ?> Answers: </h5>
        <?php for ($i = 0; $i < count($answers); $i++) : ?>
            <div class="d-flex my-5">
                <span style="height: fit-content;" class="badge text-bg-secondary m-2 mx-4 p-2">#<?= $i + 1 ?></span>
                <div class="vr" style="width: 2px;"></div>
                <p class="m-2 mx-4"><?= nl2br($answers[$i]['content']) ?></p>
            </div>
            <div class='d-flex justify-content-between'>
                <p class="m-4 text-warning-emphasis"><small>Time: <?= str_replace(["-", " "], [".", " - "], $answers[$i]["creationTime"]) ?></small></p>
                <?php if ($answers[$i]["login"] === $_SESSION["login"]) : ?>
                    <p class="m-4 mb-0 text-warning-emphasis"><small>Your answer</small></p>
                <?php else: ?>
                    <p class="m-4 mb-0 text-warning-emphasis"><small>Answer from customer: "<a href="/profile/<?= $answers[$i]["login"] ?>"><?= $answers[$i]["login"] ?></a>"</small></p>
                <?php endif; ?>
            </div>

            <?php if ($answers[$i]["login"] === $_SESSION["login"] or $_SESSION["status"] === "moderator" or $_SESSION["status"] === "admin") : ?>
                <a class="text-danger" href="/delete/answers/<?= $answers[$i]['id'] ?>">Delete Answer</a>
            <?php endif; ?>

            <?php if ($i + 1 < count($answers)) : ?>
                <hr class="border border-secondary border-1 opacity-50">
            <?php endif; ?>
        <?php endfor; ?>
    <?php else : ?>
        <h6 class="m-4">There is not a single answer to this question yet and you can answer first! :)</h6>
    <?php endif; ?>
    <hr class="border border-secondary border-1 opacity-50">
    <h5 class="m-4">Your Answer: </h5>
    <form action="" method="POST" class="px-4">
        <textarea class="form-control p-3" rows="10" cols="45" name="answer" placeholder="Your answer" minlength="15" required><?= $_POST["answer"] ?? "" ?></textarea>
        <div class="form-text">Please describe your answer in detail!</div>
        <input class="btn btn-primary mt-4" type="submit" name="submit" value="Post your answer" />
    </form>
</div>