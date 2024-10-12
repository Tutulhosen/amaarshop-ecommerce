@extends('frontend.layout.app')

@section('main-content')
<div class="dashboard-container">
    <!-- Account Update Form -->
    <div class="form-container">
        <h2>Update Account Information</h2>
        <form id="updateForm">
            @csrf
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" value="{{Auth::guard('customer')->user()->name}}" required>

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" value="{{Auth::guard('customer')->user()->email}}" required>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" value="{{Auth::guard('customer')->user()->phone}}" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password">

            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm-password">

            <button type="button" class="btn">Update Information</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')

<script>
    $(document).ready(function() {
        // On form submit button click
        $('.btn').on('click', function(e) {
            e.preventDefault();
            
            let password = $('#password').val();
            let confirm_password = $('#confirm_password').val();

            // Password validation
            if (password && password !== confirm_password) {
                toastr.error('Passwords do not match!', 'Error', {
                    closeButton: true,
                    onShown: function() {
                        if (!document.querySelector('.toastr-cancel-button')) {
                            let toast = document.querySelector('.toast-error');
                            
                            cancelButton.innerHTML = 'Cancel';

                            cancelButton.onclick = function() {
                                toastr.clear(); // Close the toastr notification
                            };

                            toast.querySelector('.toast-message').appendChild(cancelButton);
                        }
                    }
                });
                return; // Stop form submission if passwords don't match
            }

            // Perform AJAX request to submit form data
            $.ajax({
                url: "{{ route('user.profile.update') }}",
                method: 'POST',
                data: $('#updateForm').serialize(), // Serialize form data
                success: function(response) {
                    toastr.success('Account information updated successfully!', 'Success', {
                        closeButton: true,
                        onShown: function() {
                            if (!document.querySelector('.toastr-cancel-button')) {
                                let toast = document.querySelector('.toast-success');
                    
                                cancelButton.innerHTML = 'Cancel';
                                

                                cancelButton.onclick = function() {
                                    toastr.clear();
                                };

                                toast.querySelector('.toast-message').appendChild(cancelButton);
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    toastr.error('Failed to update account information.', 'Error');
                }
            });
        });
    });
</script>
@endsection
