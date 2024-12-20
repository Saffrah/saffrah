@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card border shadow-xs mb-4">
            <div class="card-header border-bottom pb-0">
                <div class="d-sm-flex align-items-center">
                    <div>
                        <h6 class="font-weight-semibold text-lg mb-0">Companies list</h6>
                        <p class="text-sm">See information about all Companies</p>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 py-0">
                <div class="border-bottom py-3 px-3 d-sm-flex align-items-center">
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input id="filter-all" type="radio" class="btn-check" name="btnradiotable" autocomplete="off" checked>
                        <label class="btn btn-white px-3 mb-0" for="filter-all">All</label>
                        <input id="filter-verified" type="radio" class="btn-check" name="btnradiotable" autocomplete="off">
                        <label class="btn btn-white px-3 mb-0" for="filter-verified">Verified</label>
                        <input id="filter-pending" type="radio" class="btn-check" name="btnradiotable" autocomplete="off">
                        <label class="btn btn-white px-3 mb-0" for="filter-pending">Pending</label>
                    </div>
                    <div class="input-group w-sm-25 ms-auto">
                        <span class="input-group-text text-body">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                        </svg>
                        </span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Search">
                    </div>
                </div>
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="companiesTable">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7">Company</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Registration No.</th>
                                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Status</th>
                                <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Reegistered At</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($companies as $key => $company)
                            <tr data-status="{{ $company->email_verified_at ? 'verified' : 'pending' }}" data-company-id="{{ $company->id }}">
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex align-items-center">
                                            <img src="../assets/img/team-2.jpg" class="avatar avatar-sm rounded-circle me-2" alt="user1">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center ms-1">
                                            <h6 class="mb-0 text-sm font-weight-semibold">{{ $company->name }}</h6>
                                            <p class="text-sm text-secondary mb-0">{{ $company->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm text-dark font-weight-semibold mb-0">Commercial: {{ $company->commercial_number }}</p>
                                    <p class="text-sm text-secondary mb-0">Taxes: {{ $company->tax_number }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    @if($company->email_verified_at)
                                    <span class="badge badge-sm border border-success text-success bg-success cursor-pointer status-tag">
                                        <svg width="9" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" class="me-1">
                                            <path d="M1 4.42857L3.28571 6.71429L9 1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        Verified
                                    </span>
                                    @else
                                    <span class="badge badge-sm border border-warning text-warning bg-warning cursor-pointer status-tag">
                                        <svg width="12" height="12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="me-1ca">
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                                        </svg>
                                        Pending
                                    </span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-sm font-weight-normal">{{ $company->created_at->toDateString() }}</span>
                                </td>
                                <td class="align-middle">
                                    <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-bs-toggle="tooltip" data-bs-title="Edit user">
                                        <svg width="15" height="15" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.2201 2.02495C10.8292 1.63482 10.196 1.63545 9.80585 2.02636C9.41572 2.41727 9.41635 3.05044 9.80726 3.44057L11.2201 2.02495ZM12.5572 6.18502C12.9481 6.57516 13.5813 6.57453 13.9714 6.18362C14.3615 5.79271 14.3609 5.15954 13.97 4.7694L12.5572 6.18502ZM11.6803 1.56839L12.3867 2.2762L12.3867 2.27619L11.6803 1.56839ZM14.4302 4.31284L15.1367 5.02065L15.1367 5.02064L14.4302 4.31284ZM3.72198 15V16C3.98686 16 4.24091 15.8949 4.42839 15.7078L3.72198 15ZM0.999756 15H-0.000244141C-0.000244141 15.5523 0.447471 16 0.999756 16L0.999756 15ZM0.999756 12.2279L0.293346 11.5201C0.105383 11.7077 -0.000244141 11.9624 -0.000244141 12.2279H0.999756ZM9.80726 3.44057L12.5572 6.18502L13.97 4.7694L11.2201 2.02495L9.80726 3.44057ZM12.3867 2.27619C12.7557 1.90794 13.3549 1.90794 13.7238 2.27619L15.1367 0.860593C13.9869 -0.286864 12.1236 -0.286864 10.9739 0.860593L12.3867 2.27619ZM13.7238 2.27619C14.0917 2.64337 14.0917 3.23787 13.7238 3.60504L15.1367 5.02064C16.2875 3.8721 16.2875 2.00913 15.1367 0.860593L13.7238 2.27619ZM13.7238 3.60504L3.01557 14.2922L4.42839 15.7078L15.1367 5.02065L13.7238 3.60504ZM3.72198 14H0.999756V16H3.72198V14ZM1.99976 15V12.2279H-0.000244141V15H1.99976ZM1.70617 12.9357L12.3867 2.2762L10.9739 0.86059L0.293346 11.5201L1.70617 12.9357Z" fill="#64748B" />
                                        </svg>
                                    </a>
                                    
                                    <a href="javascript:;" class="text-secondary font-weight-bold text-xs m-2" data-bs-toggle="tooltip" data-bs-title="Edit user">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="border-top py-3 px-3 d-flex align-items-center">
                    <p class="font-weight-semibold mb-0 text-dark text-sm">Page 1 of 10</p>
                    <div class="ms-auto">
                        <button class="btn btn-sm btn-white mb-0">Previous</button>
                        <button class="btn btn-sm btn-white mb-0">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('JavaScript')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Select all filter buttons
        const filterAll      = document.getElementById('filter-all');
        const filterVerified = document.getElementById('filter-verified');
        const filterPending  = document.getElementById('filter-pending');
        const tableRows      = document.querySelectorAll('tbody tr');

        // Function to filter rows based on the selected filter
        function filterTable(filterType) {
            tableRows.forEach(row => {
                const status = row.getAttribute('data-status');

                if (filterType === 'all' || status === filterType) {
                    row.style.display = ''; // Show row
                } else {
                    row.style.display = 'none'; // Hide row
                }
            });
        }

        // Add event listeners to the radio buttons
        filterAll.addEventListener('change', () => filterTable('all'));
        filterVerified.addEventListener('change', () => filterTable('verified'));
        filterPending.addEventListener('change', () => filterTable('pending'));

        const searchInput = document.getElementById('searchInput');
        const table       = document.getElementById('companiesTable');

        // Add event listener to search input
        searchInput.addEventListener('input', function () {
            const query = searchInput.value.toLowerCase(); // Get search value (case insensitive)

            tableRows.forEach((row) => {
                const companyName = row.cells[0].textContent.toLowerCase(); // Get company name (first column)
                if (companyName.includes(query)) {
                    row.style.display = ''; // Show row
                } else {
                    row.style.display = 'none'; // Hide row
                }
            });
        });
    });
    // Add event listener to the status tags
    document.querySelectorAll('.status-tag').forEach(tag => {
        tag.addEventListener('click', function() {
            // Get the company ID and current status
            const companyId     = this.closest('tr').dataset.companyId;
            const currentStatus = this.closest('tr').dataset.status;

            if (currentStatus === 'pending') {
                // Send POST request to update the company status to 'verified'
                fetch('/api/companies/update_status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ company_id: companyId, new_status: 'verify' })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // On success, update the tag text and status
                        this.innerHTML = '<svg width="9" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" class="me-1"><path d="M1 4.42857L3.28571 6.71429L9 1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>Verified';
                        this.classList.remove('border-warning');
                        this.classList.remove('text-warning');
                        this.classList.remove('bg-warning');
                        this.classList.add('border-success');
                        this.classList.add('text-success');
                        this.classList.add('bg-success');
                        this.dataset.status = 'verified';
                    } else {
                        // Handle failure case (optional)
                        alert('Failed to update status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
            else if (currentStatus === 'verified') {
                // Send POST request to update the company status to 'verified'
                fetch('/api/companies/update_status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ company_id: companyId, new_status: 'unverify' })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // On success, update the tag text and status
                        this.innerHTML = '<svg width="12" height="12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="me-1ca"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" /></svg>Pending';
                        this.classList.remove('border-success');
                        this.classList.remove('text-success');
                        this.classList.remove('bg-success');
                        this.classList.add('border-warning');
                        this.classList.add('text-warning');
                        this.classList.add('bg-warning');
                        this.dataset.status = 'Pending';
                    } else {
                        // Handle failure case (optional)
                        alert('Failed to update status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    });
</script>
@stop