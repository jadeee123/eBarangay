document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.request-tab');
    const searchInput = document.getElementById('requestSearch');
    const requestTable = document.getElementById('requestTable');
    const emptyState = document.getElementById('emptyState');

    const filterButton = document.getElementById('requestFilterBtn');
    const filterPanel = document.getElementById('requestFilterPanel');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    const statusFilter = document.getElementById('statusFilter');
    const clearFilters = document.getElementById('clearFilters');

    if (
        !requestTable ||
        !emptyState ||
        !searchInput ||
        !filterButton ||
        !filterPanel ||
        !dateFrom ||
        !dateTo ||
        !statusFilter ||
        !clearFilters
    ) return;

    const params = new URLSearchParams(window.location.search);
    const dashboardFilter = params.get('filter') || 'all';

    let selectedTab = 'active';

    // Apply dashboard card filter
    if (dashboardFilter === 'pending' || dashboardFilter === 'approved') {
        statusFilter.value = dashboardFilter;
    } else if (dashboardFilter === 'claim-dates') {
        statusFilter.value = 'all';
    } else {
        statusFilter.value = 'all';
    }

    function updateRequests() {
        const rows = requestTable.querySelectorAll('tr');
        const searchValue = searchInput.value.toLowerCase().trim();
        const fromDate = dateFrom.value;
        const toDate = dateTo.value;
        const selectedStatus = statusFilter.value;

        let visibleCount = 0;

        rows.forEach(function (row) {
            const rowDate = row.dataset.date || '';
            const rowStatus = (row.dataset.status || '').toLowerCase();
            const rowText = row.textContent.toLowerCase();
            const hasClaimDate = row.dataset.claimDate === 'yes';

            const matchesTab = selectedTab === 'completed'
                ? rowStatus === 'completed'
                : rowStatus !== 'completed';

            const matchesDashboard =
                dashboardFilter !== 'claim-dates' || hasClaimDate;

            const matchesSearch = rowText.includes(searchValue);

            const matchesFromDate = !fromDate ||
                (rowDate && rowDate >= fromDate);

            const matchesToDate = !toDate ||
                (rowDate && rowDate <= toDate);

            const matchesStatus = selectedStatus === 'all' ||
                rowStatus === selectedStatus;

            const shouldShow =
                matchesTab &&
                matchesDashboard &&
                matchesSearch &&
                matchesFromDate &&
                matchesToDate &&
                matchesStatus;

            row.hidden = !shouldShow;

            if (shouldShow) {
                visibleCount++;
            }
        });

        emptyState.hidden = visibleCount > 0;
    }

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            tabs.forEach(function (item) {
                item.classList.remove('active');
            });

            tab.classList.add('active');
            selectedTab = tab.dataset.status;
            updateRequests();
        });
    });

    filterButton.addEventListener('click', function () {
        filterPanel.hidden = !filterPanel.hidden;
    });

    searchInput.addEventListener('input', updateRequests);
    dateFrom.addEventListener('change', updateRequests);
    dateTo.addEventListener('change', updateRequests);
    statusFilter.addEventListener('change', updateRequests);

    clearFilters.addEventListener('click', function () {
        dateFrom.value = '';
        dateTo.value = '';
        statusFilter.value = 'all';
        searchInput.value = '';
        updateRequests();
    });

    updateRequests();
});


function openRequestModal(button) {
    const modal = document.getElementById('requestModal');

    if (!modal) return;

    const requestId = button.dataset.id;
    const status = (button.dataset.status || 'pending').toLowerCase();
    const claimDate = button.dataset.claimDate || '';

    document.getElementById('modalRequestId').textContent =
        'Request #' + requestId;

    document.getElementById('modalService').textContent =
        button.dataset.service || 'N/A';

    document.getElementById('modalDescription').textContent =
        button.dataset.description || 'No description provided.';

    document.getElementById('modalStatus').textContent =
        button.dataset.status || 'Pending';

    document.getElementById('modalSubmitted').textContent =
        button.dataset.submitted
            ? new Date(button.dataset.submitted).toLocaleDateString()
            : 'N/A';

    document.getElementById('modalClaimDate').textContent =
        claimDate || 'Not yet scheduled';

    // Update request progress
    const submittedStep = document.getElementById('stepSubmitted');
    const reviewStep = document.getElementById('stepReview');
    const claimStep = document.getElementById('stepClaim');

    const isRejected = status === 'rejected';
    const isCompleted = status === 'completed';
    const isProcessing = status === 'processing';
    const isApproved = status === 'approved';

    submittedStep.classList.add('completed');
    reviewStep.classList.remove('completed', 'rejected');
    claimStep.classList.remove('completed', 'rejected');

    if (isProcessing || isApproved || isCompleted || isRejected) {
        reviewStep.classList.add('completed');
    }

    if (isCompleted) {
        claimStep.classList.add('completed');

        document.getElementById('claimStepTitle').textContent =
            'Completed';

        document.getElementById('modalClaimInstructions').textContent =
            'Your request has been completed.';
    } else if (isRejected) {
        claimStep.classList.add('rejected');

        document.getElementById('claimStepTitle').textContent =
            'Request Rejected';

        document.getElementById('modalClaimInstructions').textContent =
            'Please contact the barangay office for more information.';
    } else {
        document.getElementById('claimStepTitle').textContent =
            'Ready for Claim';

        document.getElementById('modalClaimInstructions').textContent =
            claimDate
                ? 'Your request has a scheduled claim date.'
                : isApproved
                    ? 'Your request is approved. The claim date has not yet been scheduled.'
                    : 'Your request is awaiting processing.';
    }

    // Update feedback section
    const feedbackSection =
        document.getElementById('requestFeedbackSection');
    const feedbackForm = document.getElementById('feedbackForm');
    const feedbackMessage =
        document.getElementById('feedbackAlreadySubmitted');
    const feedbackComment =
        document.getElementById('feedbackComment');

    const existingRating = button.dataset.feedbackRating;
    const existingComment = button.dataset.feedbackComment || '';

    feedbackSection.style.display = 'none';
    feedbackForm.style.display = 'block';
    feedbackMessage.style.display = 'none';

    feedbackForm.reset();

    // Only completed requests can receive feedback
    if (isCompleted) {
        feedbackSection.style.display = 'block';
        feedbackForm.action = `/requests/${requestId}/feedback`;

        if (existingRating !== '') {
            feedbackForm.style.display = 'none';
            feedbackMessage.style.display = 'block';

            feedbackMessage.textContent =
                `Thank you! You rated this service ${existingRating}/5 stars.` +
                (existingComment
                    ? ` Your comment: ${existingComment}`
                    : '');
        } else {
            feedbackComment.value = '';
        }
    }

    modal.style.display = 'flex';
}

const submittedStep = document.getElementById('stepSubmitted');
const reviewStep = document.getElementById('stepReview');
const claimStep = document.getElementById('stepClaim');

const status = (button.dataset.status || 'pending').toLowerCase();
const claimDate = button.dataset.claimDate;

const isRejected = status === 'rejected';
const isCompleted = status === 'completed';
const isProcessing = status === 'processing';
const isApproved = status === 'approved';

submittedStep.classList.add('completed');
reviewStep.classList.remove('completed', 'rejected');
claimStep.classList.remove('completed', 'rejected');

if (isProcessing || isApproved || isCompleted || isRejected) {
    reviewStep.classList.add('completed');
}

if (isCompleted) {
    claimStep.classList.add('completed');
    document.getElementById('modalClaimInstructions').textContent =
        'Your request has been completed.';
} else if (isRejected) {
    claimStep.classList.add('rejected');
    document.getElementById('claimStepTitle').textContent = 'Request Rejected';
    document.getElementById('modalClaimInstructions').textContent =
        'Please contact the barangay office for more information.';
} else {
    document.getElementById('claimStepTitle').textContent = 'Ready for Claim';

    if (claimDate) {
        claimStep.classList.add('completed');
        document.getElementById('modalClaimInstructions').textContent =
            'Your request has a scheduled claim date.';
    } else {
        document.getElementById('modalClaimInstructions').textContent =
            isApproved
                ? 'Your request is approved. The claim date has not yet been scheduled.'
                : 'Your request is awaiting processing.';
    }
}

function closeRequestModal() {
    const modal = document.getElementById('requestModal');

    if (modal) {
        modal.style.display = 'none';
    }
}



