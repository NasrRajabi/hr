
function getUser(button, row) {
  const showGetUserModal = new bootstrap.Modal(
    document.getElementById("showGetUserModal")
  );

  post(
    `/attendance/devices/get_user`,
    {
      device_ip: row.ip,
    },
    button
  ).then((response) => {
    if (response.ok) {
      response
        .json()
        .then((response) => openGetUserModal(showGetUserModal, response));
    }
  });
}

function setUser(button, row, add_employee_no, role) {
  const addEmpModal = new bootstrap.Modal(
    document.getElementById("addEmp" + row.id)
  );
  post(
    `/attendance/devices/set_user`,
    {
      employee_no: add_employee_no,
      role: role,
      device_ip: row.ip,
    },
    button,
    addEmpModal
  ).then((response) => {
    if (response.ok) {
      response
        .json()
        .then((response) => hideAddEmpModal(addEmpModal, response));
    }
  });
}
function storeDevice(button, name, device_ip, area) {
  const storeDeviceModel = new bootstrap.Modal(
    document.getElementById("add_device")
  );
  post(
    `/attendance/devices/add`,
    {
      name: name,
      device_ip: device_ip,
      area: area,
    },
    button,
    storeDeviceModel
  ).then((response) => {
    if (response.ok) {
      response
        .json()
        .then((response) => openGetUserModal(showGetUserModal, response));
    }
  });
}

function editDevice(button, row, name, device_ip, area) {
  const editDeviceModel = new bootstrap.Modal(
    document.getElementById("editDevice" + row.id)
  );
  post(
    `/attendance/devices/edit`,
    {
      id: row.id,
      name: name,
      device_ip: device_ip,
      area: area,
    },
    button,
    editDeviceModel
  ).then((response) => {
    if (response.ok) {
      response
        .json()
        .then((response) => openGetUserModal(showGetUserModal, response));
    }
  });
}

function checkConnect(button, row, progress = false) {
  post(
    `/attendance/devices/check_connect`,
    {
      device_ip: row.ip,
    },
    button,
    null,
    progress
  ).then((response) => {
    if (response.ok) {
      response.json().then((response) => showCheckConnectStatus(row, response));
    }
  });
}

function restart(button, row) {
  post(
    `/attendance/devices/restart`,
    {
      device_ip: row.ip,
    },
    button
  ).then((response) => {
    if (response.ok) {
      response.json().then((response) => handleSuccess(response));
    }
  });
}
function checkVoice(button, row) {
  post(
    `/attendance/devices/check_voice`,
    {
      device_ip: row.ip,
    },
    button
  ).then((response) => {
    if (response.ok) {
      response.json().then((response) => handleSuccess(response));
    }
  });
}
function setTime(button, row, progress = false) {
  post(
    `/attendance/devices/set_time`,
    {
      device_ip: row.ip,
    },
    button,
    null,
    progress
  ).then((response) => {
    if (response.ok) {
      if (progress == false) {
        response.json().then((response) => handleSuccess(response));
      } else {
        response.json().then((response) => handleResult(row, response));
      }
    }
  });
}

// أيقونة سحب الدوام لكل ساعة
function transferData(button, row, progress = false) {
  post(
    `/attendance/devices/transfer_data`,
    {
      device_ip: row.ip,
    },
    button,
    null,
    progress
  ).then((response) => {
    if (response.ok) {
      response.json().then((response) => handleResult(row, response));
    }
  });
} 


function details(button, row) {
  const showGetUserModal = new bootstrap.Modal(
    document.getElementById("showGetUserModal")
  );

  post(
    `/attendance/devices/details`,
    {
      device_ip: row.ip,
      name: row.ip, 
    },
    button
  ).then((response) => {
    if (response.ok) {
      response
        .json()
        .then((response) => openGetUserModal(showGetUserModal, response));
    }
  });
}

function removeUser(button, uid, ip) {
  const showGetUserModal = new bootstrap.Modal(
    document.getElementById("showGetUserModal")
  );
  console.log(uid);
  post(
    `/attendance/devices/remove_user`,
    {
      employee_id: uid,
      device_ip: ip,
    },
    button,
    showGetUserModal
  ).then((response) => {
    if (response.ok) {
      response.json().then((response) => handleSuccess(response));
    }
  });
}

function showCheckConnectStatus(row, response) {
  if (response === "not connected") {
    row.status = `<div class="spinner-grow text-danger spinner-grow-sm" role="status">
            <span class="visually-hidden">Not Connected...</span>
          </div>`;
  } else if (response === "connected") {
    row.status = `<div class="spinner-grow text-success spinner-grow-sm" role="status">
            <span class="visually-hidden">Connected...</span>
          </div>`;
  } else {
    row.status = `<div class="spinner-grow text-warning spinner-grow-sm" role="status">
            <span class="visually-hidden">unknown Connection status...</span>
          </div>`;
  }
}
function handleResult(row, response) {
  if (response != "الساعة غير متصلة") {
    row.data = `<small class="d-inline-flex px-2 py-1 fw-semibold text-success-emphasis bg-success-subtle border border-success-subtle rounded-2 fs-6">${response}</small>`;
  } else {
    row.data = `<small class="d-inline-flex px-2 py-1 fw-semibold text-warning-emphasis bg-warning-subtle border border-warning-subtle rounded-2 fs-6">${response}</small>`;
  }
}

function openGetUserModal(modal, response) {
  createTableRows(response); // Call the function to create table rows
  modal.show();
}
function hideAddEmpModal(modal, response) {
  modal.show();
  handleSuccess(response);
}

// Function to create table rows
function createTableRows(data) {
  var tbody = document.querySelector("#getUserTable tbody");
  tbody.innerHTML = ` `;
  device_ip = data["device_ip"].toString();

  delete data["device_ip"];

  Object.values(data).forEach(function (rowData) {
    id = rowData.uid;
    var row = document.createElement("tr");
    var uidCell = document.createElement("td");
    uidCell.textContent = rowData.uid;
    row.appendChild(uidCell);

    var nameCell = document.createElement("td");
    nameCell.textContent = rowData.name;
    row.appendChild(nameCell);

    var userIdCell = document.createElement("td");
    userIdCell.textContent = rowData.userid;
    row.appendChild(userIdCell);

    var roleCell = document.createElement("td");
    roleCell.textContent = rowData.role;
    row.appendChild(roleCell);

    var roleCell = document.createElement("td");
    roleCell.innerHTML = `	<button x-on:click="removeUser($event.target,${id}, '${device_ip}')" type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="حذف موظف">
                                    <i class="bi bi-person-x fs-5"></i>
                            </button>`;
    row.appendChild(roleCell);

    tbody.appendChild(row);
  });
}
