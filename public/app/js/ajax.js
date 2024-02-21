// Declare the total number of AJAX calls
let totalAjaxCalls = 0; // Replace 3 with the actual number of AJAX calls

// Counter for completed AJAX calls
let completedAjaxCalls = 0;

const ajax = (
  url,
  method = "get",
  data = {},
  button = null,
  domElement = null,
  progress = false
) => {
  // Create the spinner element
  const spinnerBtn = document.createElement("span");
  spinnerBtn.className = "spinner-border spinner-border-sm";
  spinnerBtn.setAttribute("role", "status");
  spinnerBtn.setAttribute("aria-hidden", "true");
  const progressBar = document.getElementById("progress");
  if (progress == false) {
    // Show the spinner
    const spinner = document.getElementById("spinner");
    spinner.style.display = "flex";

    if (button != null) {
      // Disable the button
      button.disabled = true;

      // Append the spinner to the button
      button.appendChild(spinnerBtn);
    }
  } else {
    totalAjaxCalls = progress;
    completedAjaxCalls = 0;
    if (progressBar) {
      progressBar.style.display = "flex";
    }
  }

  method = method.toLowerCase();

  let options = {
    method,
    headers: {
      "Content-Type": "application/json",
      "X-Requested-With": "XMLHttpRequest",
    },
  };

  const csrfMethods = new Set(["post", "put", "delete", "patch"]);

  if (csrfMethods.has(method)) {
    if (method !== "post") {
      options.method = "post";

      data = { ...data, _METHOD: method.toUpperCase() };
    }

    options.body = JSON.stringify({ ...data, ...getCsrfFields() });
  } else if (method === "get") {
    url += "?" + new URLSearchParams(data).toString();
  }
  // Update the progress bar
  function updateProgressBar(value) {
    const progressBar = document.querySelector("#progress .progress-bar");
    progressBar.style.width = value + "%";
    progressBar.setAttribute("aria-valuenow", value);
  }

  // Calculate and update the progress bar
  const updateProgress = () => {
    const progress = (completedAjaxCalls / totalAjaxCalls) * 100;
    updateProgressBar(progress);
  };

  return fetch(url, options)
    .then((response) => {
      if (domElement) {
        
        clearValidationErrors(domElement);
      }

      if (!response.ok) {
        if (response.status === 422) {
          response.json().then((errors) => {
            console.log(domElement);
            handleValidationErrors(errors, domElement);
          });
        }
        if (response.status === 403) {
          closeModal();
          response.json().then((errors) => {
            openErrorPermModal(errors);
          });
        }


        if (response.status === 400) {
          response.json().then((errors) => {
            handleBadRequestErrors(errors, domElement);
          });
        }
      }

      return response;
    })
    .finally(() => {
      // Hide the spinner
      if (progress == false) {
        spinner.style.display = "none";
        if (button != null) {
          // Remove the spinnerBtn from the button
          button.removeChild(spinnerBtn);

          // Enable the button
          button.disabled = false;
        }
      } else {
        completedAjaxCalls = completedAjaxCalls + 1; // Increment the completed AJAX calls counter
        if (progressBar) {
          updateProgress();
        }
        

        if (completedAjaxCalls === totalAjaxCalls) {
          // All AJAX calls completed
          // Perform any additional actions here
          completedAjaxCalls = 0;
          if (progressBar) {
            updateProgress();
            progressBar.style.display = "none";
          }
        }
        //  progressBar.style.display = "none";
        /*if (button != null) {
          // Remove the spinnerBtn from the button
          button.removeChild(spinnerBtn);

          // Enable the button
          button.disabled = false;
        }*/
      }
    });
};

const get = (url, data, button = null, domElement = null, progress = false) =>  ajax(url, "get", data, button, domElement, progress);
const post = (url, data, button = null, domElement, progress = false) =>  ajax(url, "post", data, button, domElement, progress);
const del = (url, data, button = null) => ajax(url, "delete", data, button);

// function handleValidationErrors(errors, domElement) {
//   let missingFieldsError = "";

//   for (const name in errors) {
//     const element = domElement._element.querySelector(`[name="${name}"]`);
//     if (element) {
//       element.classList.add("is-invalid");

//       for (const error of errors[name]) {
//         const errorDiv = document.createElement("div");
//         errorDiv.classList.add("invalid-feedback");
//         errorDiv.textContent = error;
//         element.parentNode.append(errorDiv);
//       }
//     } else {
//       for (const error of errors[name]) {
//         missingFieldsError += `<div class="alert alert-danger" role="alert"> "${error}" </div>`;
//       }
//     }
//   }

//   if (missingFieldsError !== "") {
//     const errorModalBody = document.getElementById("errorModalBody");
//     errorModalBody.innerHTML = missingFieldsError;

//     // Show the error modal
//     const modalInstance = new bootstrap.Modal(
//       document.getElementById("errorModal")
//     );
//     modalInstance.show();
//   }
// }

function handleValidationErrors(errors, domElement) {
  let missingFieldsError = "";

  for (const name in errors) {
    const element = domElement._element.querySelector(`[name="${name}"]`);
    if (element) {
      element.classList.add("is-invalid");

      for (const error of errors[name]) {
        const errorDiv = document.createElement("div");
        errorDiv.classList.add("invalid-feedback");
        errorDiv.textContent = error;
        element.parentNode.append(errorDiv);
      }
    } else {
      for (const error of errors[name]) {
        missingFieldsError += `<div class="alert alert-danger" role="alert"> "${error}" </div>`;
      }
    }
  }

  if (missingFieldsError !== "") {
    const errorContainer = document.getElementById("errorContainer");
    errorContainer.innerHTML = missingFieldsError;
  }
}
function handleBadRequestErrors(error) {
  let missingFieldsError = "";

  missingFieldsError += `<div class="alert alert-warning" role="alert"> ${error} </div>`;

  if (missingFieldsError !== "") {
    const errorModalBody = document.getElementById("errorModalBody");
    errorModalBody.innerHTML = missingFieldsError;

    // Show the error modal
    const modalInstance = new bootstrap.Modal(
      document.getElementById("errorModal")
    );
    modalInstance.show();
  }
}
function handleSuccess(success) {
  console.log(success);
  let missingFieldsSuccess = "";

  missingFieldsSuccess += `<div class="alert alert-success" role="alert"> ${success} </div>`;

  if (missingFieldsSuccess !== "") {
    const successModalBody = document.getElementById("successModalBody");
    successModalBody.innerHTML = missingFieldsSuccess;

    // Show the success modal
    const modalInstance = new bootstrap.Modal(
      document.getElementById("successModal")
    );
    modalInstance.show();
  }
}

function clearValidationErrors(domElement) {
  domElement._element
    .querySelectorAll(".is-invalid")
    .forEach(function (element) {
      element.classList.remove("is-invalid");

      element.parentNode
        .querySelectorAll(".invalid-feedback")
        .forEach(function (e) {
          e.remove();
        });
    });
}

function getCsrfFields() {
  const csrfNameField = document.querySelector("#csrfName");
  const csrfValueField = document.querySelector("#csrfValue");
  const csrfNameKey = csrfNameField.getAttribute("name");
  const csrfName = csrfNameField.content;
  const csrfValueKey = csrfValueField.getAttribute("name");
  const csrfValue = csrfValueField.content;

  return {
    [csrfNameKey]: csrfName,
    [csrfValueKey]: csrfValue,
  };

}


function hideModal(myModalID) {
  var modal = document.getElementById(myModalID);
  modal.classList.remove('show');
  modal.setAttribute('aria-hidden', 'true');
  modal.setAttribute('style', 'display: none');

  var backdrop = document.getElementsByClassName('modal-backdrop show')[0];
  backdrop.parentNode.removeChild(backdrop);
}


function closeModal() {
  // Get the currently active modal by its class name
  var activeModal = document.querySelector('.modal.show');

  // Use JavaScript to close the active modal
  if (activeModal) {
    activeModal.classList.remove('show');
    activeModal.style.display = 'none';
    document.body.classList.remove('modal-open');

    // Remove the backdrop element if it exists
    var backdropElement = document.querySelector('.modal-backdrop');
    if (backdropElement) {
      backdropElement.remove();
    }
  }
}
function openErrorPermModal(errors) {
  var errorModal = document.getElementById('errorPermModal');

  if (errorModal) {
    errorModal.classList.add('show');
    errorModal.style.display = 'block';
    errorModal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('modal-open');


    // Check if errors is not null before updating innerText
    if (errors !== null) {
      document.getElementById('errorBody').innerText = errors;

    } else {
      document.getElementById('errorBody').innerText =  "خطأ في الصلاحيات";
    }

    var backdropElement = document.querySelector('.modal-backdrop');
    if (!backdropElement) {
      backdropElement = document.createElement('div');
      backdropElement.classList.add('modal-backdrop', 'fade', 'show');
      document.body.appendChild(backdropElement);
    }
}
}
