<?= $this->renderLayout('header'); ?>

<!-- My Journals Section -->
<section class="py-5 bg-body">
    <div class="container">
        <h2 class="text-center mb-4">My Journals</h2>

        <div class="text-center mb-4">
            <a href="/journal/create" class="btn btn-teal btn-lg shadow">New Journal Entry</a>
        </div>

        <!-- Search Filter -->
        <div class="mb-4">
            <input type="text" class="form-control" placeholder="Search by title, content, or tags" aria-label="Search Journals">
        </div>

        <div class="row mb-4">
            <div class="col-lg-8">
                <div class="btn-group" role="group" aria-label="View options">
                    <input type="radio" class="btn-check" name="viewOptions" id="cardView" autocomplete="off" checked>
                    <label class="btn btn-outline-secondary" for="cardView">Card View</label>

                    <input type="radio" class="btn-check" name="viewOptions" id="listView" autocomplete="off">
                    <label class="btn btn-outline-secondary" for="listView">List View</label>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Journal Entry Card 1 -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-body rounded">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <h5 class="card-title my-auto text-truncate" style="max-width: 70%;">Entry Title 1</h5>
                            <button class="btn" title="Pin Entry">
                                <i class="bi bi-pin"></i>
                            </button>
                        </div>
                        <p class="card-text">This is a brief description of your first journal entry, capturing key thoughts and feelings.</p>
                        <p class="card-text">
                            <small class="text-muted">Tags: <span class="badge bg-secondary">Usual</span> <span class="badge bg-secondary">Personal</span></small>
                        </p>
                        <p class="card-text">
                            <small class="text-muted">Date: January 1, 2024 | Time: 10:00 AM</small>
                        </p>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="/journal/1" class="btn btn-primary me-2">View</a>
                            <a href="#" class="btn btn-mauve">Edit</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Journal Entry Card 2 -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-body rounded">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <h5 class="card-title my-auto text-truncate" style="max-width: 70%;">Entry Title 2</h5>
                            <button class="btn" title="Pin Entry">
                                <i class="bi bi-pin"></i>
                            </button>
                        </div>
                        <p class="card-text">A brief overview of your second entry, reflecting on significant moments.</p>
                        <p class="card-text">
                            <small class="text-muted">Tags: <span class="badge bg-secondary">Work</span> <span class="badge bg-secondary">Planning</span></small>
                        </p>
                        <p class="card-text">
                            <small class="text-muted">Date: January 15, 2024 | Time: 10:30 AM</small>
                        </p>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="/journal/1" class="btn btn-primary me-2">View</a>
                            <a href="#" class="btn btn-mauve">Edit</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Journal Entry Card 3 -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-body rounded">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <h5 class="card-title my-auto text-truncate" style="max-width: 70%;">Entry Title 3</h5>
                            <button class="btn" title="Pin Entry">
                                <i class="bi bi-pin"></i>
                            </button>
                        </div>
                        <p class="card-text">Description of the third journal entry goes here, highlighting key insights.</p>
                        <p class="card-text">
                            <small class="text-muted">Tags: <span class="badge bg-secondary">Special</span></small>
                        </p>
                        <p class="card-text">
                            <small class="text-muted">Date: January 25, 2024 | Time: 11:00 AM</small>
                        </p>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="/journal/1" class="btn btn-primary me-2">View</a>
                            <a href="#" class="btn btn-mauve">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- No More Entries Message -->
        <div class="text-center mt-4">
            <p class="text-muted">If you haven't written any entries yet, click the button above to start!</p>
        </div>
    </div>
</section>