<?php include $this->resolve("partials/_header.php"); ?>
<?php include $this->resolve("partials/_navbar.php"); ?>

<!-- ======= MAIN SECTION ======= -->
<section id="startPage" class="text-center">
    <div class="p-3 bg-body-tertiary rounded-3 d-flex flex-column justify-content-center align-items-center">
        <img src="/pictures/business-1297925_640.png"
            class="img-fluid mt-4 mb-3"
            style="max-width: 120px; height: auto;"
            alt="Business icon">

        <h1 class="text-body-emphasis fs-2 fs-lg-1 mb-3">Let's save some money!</h1>

        <p class="col-lg-8 mx-auto fs-6 fs-lg-5 text-muted text-center mb-4">
            The easiest way to keep your finances under control!
        </p>

        <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
            <a href="/transaction/income" class="btn btn-primary btn-lg px-4 rounded-pill">Add income</a>
            <a href="/transaction/expense" class="btn btn-outline-primary btn-lg px-4 rounded-pill">Add expense</a>
        </div>

    </div>
</section>


<?php include $this->resolve("partials/_footer.php"); ?>