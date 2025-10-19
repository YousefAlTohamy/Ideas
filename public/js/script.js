//#region Like & UnLike
// We only need the CSRF token once.
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

document.addEventListener('submit', function (event) {
    const form = event.target.closest('.like-form');
    if (!form) {
        return;
    }

    event.preventDefault();

    const url = form.action;
    const likeIcon = form.querySelector('.like-icon');

    // 1. Find the idea's ID from the form action
    const ideaId = form.action.split('/').slice(-2, -1)[0];

    // 2. Find the unique parent container for this idea's like section
    const likeContainer = document.getElementById('idea-like-' + ideaId);

    // 3. Find the like-count span WITHIN that container
    const likeCount = likeContainer.querySelector('.like-count');

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
    })
        .then(response => response.json())
        .then(data => {
            // Update the count
            if (likeCount) {
                likeCount.textContent = data.likes_count;
            }

            // Toggle the button's appearance and action
            if (form.action.endsWith('/like')) {
                // Liked state
                form.action = `/ideas/${ideaId}/unlike`;
                likeIcon.classList.remove('far');
                likeIcon.classList.add('fas', 'text-danger');
            } else {
                // Unliked state
                form.action = `/ideas/${ideaId}/like`;
                likeIcon.classList.remove('fas', 'text-danger');
                likeIcon.classList.add('far');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

//#endregion


//===================================================================================================
//===================================================================================================


//#region Share New Idea Popup
function shareIdea() {
    document.getElementById('postIdea').style.display = 'block';
}

const popup = document.getElementById('postIdea');

function closePopup() {
    popup.style.display = 'none';
}

popup.addEventListener('click', function (event) {
    if (event.target === popup) {
        closePopup();
    }
});
//#endregion


//===================================================================================================
//===================================================================================================


//#region SwalFire Messages

// popup to confirm the user edition
function confirmEditUser() {
    const form = document.getElementById('editUserForm');
    if (!form) return;
    Swal.fire({
        title: 'Do you want to save the changes?',
        showDenyButton: true,
        confirmButtonText: 'Save',
        denyButtonText: "Don't save"
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

// popup to confirm the user deletion
function confirmDeleteUser() {
    const form = document.getElementById('deleteUserForm')
    if (!form) return;
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

// popup to confirm the idea deletion
function confirmDeleteIdea() {
    const form = document.getElementById('deleteIdeaForm')
    if (!form) return;
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

// popup to confirm the comment edition
function confirmEditComment() {
    const form = document.getElementById('editCommentForm')
    if (!form) return;
    Swal.fire({
        title: "Save Changes?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Save it!"
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

// popup to confirm the comment deletion
function confirmDeleteComment() {
    const form = document.getElementById('deleteCommentForm')
    if (!form) return;
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

//#endregion


//===================================================================================================
//===================================================================================================


//#region Follows & UnFollows
document.addEventListener('submit', function (event) {
    const followForm = event.target.closest('.follow-form');
    if (!followForm) {
        return;
    }

    event.preventDefault();

    const url = followForm.action;
    const button = followForm.querySelector('button');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const authUserId = document.querySelector('meta[name="auth-user-id"]').getAttribute('content');

    fetch(url, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    })
        .then(response => response.json())
        .then(data => {
            const targetUserId = followForm.action.split('/').slice(-2, -1)[0];

            // Update follower count for the user on the page
            const followerCountElement = document.getElementById('follower-count-' + targetUserId);
            if (followerCountElement) {
                followerCountElement.textContent = data.followers_count;
            }

            // Update following count for the logged-in user
            const followingCountElement = document.getElementById('following-count-' + authUserId);
            if (followingCountElement) {
                followingCountElement.textContent = data.followings_count;
            }

            // Define the toast notification style once to keep code DRY
            const Toast = Swal.mixin({
                toast: true,
                position: "bottom-end",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });

            if (data.following) {
                // Use innerHTML to allow for icons in the future
                button.innerHTML = 'Unfollow';
                button.classList.replace('btn-primary', 'btn-danger');
                followForm.action = `/users/${targetUserId}/unfollow`;

                Toast.fire({
                    icon: "success",
                    title: "Followed successfully!"
                });
            } else {
                button.innerHTML = 'Follow';
                button.classList.replace('btn-danger', 'btn-primary');
                followForm.action = `/users/${targetUserId}/follow`;

                Toast.fire({
                    icon: "success",
                    title: "Unfollowed successfully!"
                });
            }
            if (window.followingsIDs && Array.isArray(window.followingsIDs)) {
                const id = Number(targetUserId);
                if (data.following) {
                    if (!window.followingsIDs.includes(id)) window.followingsIDs.push(id);
                } else {
                    window.followingsIDs = window.followingsIDs.filter(x => x !== id);
                }
            }
        })
        .catch(error => console.error('Follow Error:', error));
});

//#endregion


//===================================================================================================
//===================================================================================================


//#region Image Preview & Removal Logic

// This is your existing function
function removeProfilePicture(button) {
    // 1. Get the URL for the default image from the button's data attribute
    const defaultImageUrl = button.dataset.defaultImage;

    // 2. Find the image preview and update its source to the default
    const imagePreview = document.querySelector('.avatar-sm');
    if (imagePreview) {
        imagePreview.src = defaultImageUrl;
    }

    // 3. Set the hidden input value to '1' to signal removal
    document.getElementById('removeImageInput').value = '1';

    // 4. Clear the file input in case a new file was selected
    document.getElementById('image-input').value = '';

    // 5. Hide the "Remove Picture" button itself
    button.style.display = 'none';
}

// --- New Code Starts Here ---

// Find the file input element on the page
const imageInput = document.getElementById('image-input');
const imagePreview = document.querySelector('.avatar-sm');

// Add an event listener that fires when the user selects a file
imageInput.addEventListener('change', function (event) {
    // Get the selected file from the input
    const file = event.target.files[0];

    // Check if a file was actually selected
    if (file) {
        // 1. Create a new FileReader object
        const reader = new FileReader();

        // 2. Define what happens when the file is successfully read
        reader.onload = function (e) {
            // Update the 'src' of the image preview to the new file
            imagePreview.src = e.target.result;
        };

        // 3. Read the file as a Data URL (this triggers the 'onload' event)
        reader.readAsDataURL(file);

        // 4. Important: Reset the 'remove_image' flag to 0
        // This cancels the "remove" action if the user decides to upload a new picture instead
        document.getElementById('removeImageInput').value = '0';

        // 5. Show the "Remove Picture" button again in case it was hidden
        const removeButton = document.getElementById('remove-image-btn');
        if (removeButton) {
            removeButton.style.display = 'block';
        }
    }
});

//#endregion


//===================================================================================================
//===================================================================================================
