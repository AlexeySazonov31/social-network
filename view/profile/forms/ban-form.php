<style>
    .hidden-container {
        height: 0px;
        visibility: hidden;
        overflow: hidden;
        transition: height 1s;
    }
    .active {
        height: 400px;
        visibility: visible;
        transition: height 1s;
    }
</style>

<button class="btn btn-warning mt-5" id="formBanBtn">User Ban</h5>

<div class="hidden-container" id="formBanDiv">

<hr class="border border-secondary border-1 opacity-50 my-4">
<form action="" method="POST" class="mt-1">
    <!-- select ban time -->
    <div class="mb-3">
        <label for="selectTime" class="form-label">Select Time</label>
        <select class="form-select" name="time-ban" aria-label="select time" required>
            <option value="0">No Ban</option>
            <option value="3600">Hour</option>
            <option value="43200">12-Hours</option>
            <option value="86400">Day</option>
            <option value="604800">Week</option>
            <option value="2419200">Month</option>
        </select>
        <div class="form-text">Please select ban time!</div>
    </div>
    <!-- confirm input -->
    <div class="mb-3">
        <label for="InputConfirm" class="form-label">Please Confirm</label>
        <input class="form-control" type="text" name="confirm" placeholder="confirm" pattern="confirm" required />
        <div class="form-text">Please write "confirm" to confirm ban!</div>
    </div>
    <input class="btn btn-warning mt-2" type="submit" name="submitBan" value="Confirm Ban" />
</form>
</div>

<script>
    const showFormBanBtn = document.getElementById("formBanBtn");
    const formBanDiv = document.getElementById("formBanDiv");
    showFormBanBtn.addEventListener("click", () => {
        formBanDiv.classList.toggle("active");
    })
</script>