<?= $this->renderLayout('header') ?>

<section class="py-5">
    <div class="container">
        <!-- Back to Journals Button -->
        <div class="mb-4">
            <a href="/journals" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to My Journals
            </a>
        </div>

        <!-- Journal Entry Details -->
        <div class="card shadow-lg border rounded-lg p-5 mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <!-- Title -->
                <h2 class="text-teal my-auto display-6">Your Journal Title</h2>

                <!-- Export Options Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-outline-teal btn-sm dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-file-earmark-arrow-down me-1"></i> Export
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportDropdown">
                        <li><a class="dropdown-item" href="/journal/export/pdf/<?= $id ?>">
                                <i class="bi bi-file-earmark-pdf me-2"></i> Export as PDF
                            </a></li>
                        <li><a class="dropdown-item" href="/journal/export/md/<?= $id ?>">
                                <i class="bi bi-file-earmark-code me-2"></i> Export as MD
                            </a></li>
                    </ul>
                </div>
            </div>

            <!-- Date, Time, and Location -->
            <div class="d-flex align-items-center mb-4">
                <div class="me-4">
                    <i class="bi bi-calendar3 me-2 text-muted"></i>
                    <span class="text-muted"><strong>September 29, 2024</strong></span>
                </div>
                <div class="me-4">
                    <i class="bi bi-clock me-2 text-muted"></i>
                    <span class="text-muted"><strong>08:45 AM</strong></span>
                </div>
                <div>
                    <i class="bi bi-geo-alt me-2 text-muted"></i>
                    <span class="text-muted"><strong>Chennai</strong></span>
                </div>
            </div>

            <!-- Tags -->
            <div class="mb-4">
                <span class="text-muted me-2">Tags:</span>
                <span class="badge rounded-pill bg-teal px-3 py-2 me-2">Usual</span>
                <span class="badge rounded-pill bg-teal px-3 py-2">Work</span>
            </div>

            <!-- Journal Content -->
            <div class="mb-5">
                <h4 class="font-weight-bold text-muted">Content</h4>
                <p class="fs-5 lh-lg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent vel arcu ornare, viverra urna sit amet, posuere ex. Integer et velit eu erat ultricies dapibus. Phasellus ut leo vitae felis pretium fringilla. Sed dictum nulla et velit feugiat, at pharetra turpis vehicula.</p>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-between">
                <div>
                    <a href="/journal/edit/entry-id" class="btn btn-teal">
                        <i class="bi bi-pencil me-1"></i> Edit
                    </a>
                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteEntryModal">
                        <i class="bi bi-trash me-1"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Delete Entry Modal -->
<div class="modal fade" id="deleteEntryModal" tabindex="-1" aria-labelledby="deleteEntryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteEntryLabel">Delete Journal Entry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this journal entry? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger">Delete Entry</button>
            </div>
        </div>
    </div>
</div>

<?= $this->renderLayout('footer') ?>