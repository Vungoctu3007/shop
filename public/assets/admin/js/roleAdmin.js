function showListDetailRole(roleId) {
  $.ajax({
    type: "GET",
    url: `http://localhost/shop/admin/role/detail?id=${roleId}`,
    success: function (response) {
      if (response && response.data && response.data.length > 0) {
        var data = response.data;
        var roleName = data[0].role_name;

        // Đặt giá trị cho trường Role Name trong form
        $("#roleName").val(roleName);

        var taskNames = []; // Mảng lưu trữ các task_name từ response
        data.forEach(function (task) {
          taskNames.push(task.task_name);
        });

        // Hiển thị các checkbox cho các task
        var taskCheckboxesDiv = $("#taskCheckboxes");
        taskCheckboxesDiv.empty(); // Xóa bỏ các checkbox cũ trước khi thêm mới

        taskNames.forEach(function (taskName) {
          var isChecked = taskNames.includes(taskName) ? "checked" : "";
          var checkboxHtml = `
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="${taskName}" id="${taskName}" name="taskName" ${isChecked} disabled>
              <label class="form-check-label" for="${taskName}">
                ${taskName}
              </label>
            </div>
          `;
          taskCheckboxesDiv.append(checkboxHtml);
        });
      } else {
        console.error("No valid data found for this role.");
      }
      $("#detailRole").modal("show");
    },
    error: function (xhr, status, error) {
      console.error(xhr.responseText);
    },
  });
}

function openUpdateModel(roleId) {
  $.ajax({
    type: "GET",
    url: `http://localhost/shop/admin/role/detail?id=${roleId}`,
    success: function (response) {
      if (response && response.data && response.data.length > 0) {
        var data = response.data;
        var roleName = data[0].role_name;

        $("#roleId").val(roleId);
        $("#roleNameUpdate").val(roleName);

        // Tải danh sách tất cả các task từ cơ sở dữ liệu
        $.ajax({
          type: "GET",
          url: "http://localhost/shop/admin/role/getAllTask",
          success: function(allTasksResponse) {
            if (allTasksResponse && allTasksResponse.data) {
              var allTasks = allTasksResponse.data;

              var taskCheckboxesDiv = $("#taskCheckboxesUpdate");
              taskCheckboxesDiv.empty();
              console.log(allTasks)
              // Lặp qua tất cả các task và kiểm tra xem chúng có trong danh sách task của roleId không
              allTasks.forEach(function(task) {
                var isChecked = data.some(function(roleTask) {
                  return roleTask.task_id === task.task_id;
                });

                var checkboxHtml = `
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="${task.task_id}" id="${task.task_id}" name="taskName" ${isChecked ? "checked" : ""}>
                    <label class="form-check-label" for="${task.task_id}">
                      ${task.task_id} - ${task.task_name}
                    </label>
                  </div>
                `;
                taskCheckboxesDiv.append(checkboxHtml);
              });
            } else {
              console.error("No valid data found for all tasks.");
            }
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      } else {
        console.error("No valid data found for this role.");
      }
      $("#updateRoleModel").modal("show");
    },
    error: function(xhr, status, error) {
      console.error(xhr.responseText);
    },
  });
}


function updateRole() {
  var roleId = $("#roleId").val();
  var selectedTasks = [];

  $("#taskCheckboxesUpdate input:checked").each(function () {
    selectedTasks.push($(this).val());
  });

  var selectedTasksWithId = [];

  $("#taskCheckboxesUpdate input:checked").each(function () {
    var task_id = $(this).attr("id"); // Lấy task_id từ id của checkbox
    selectedTasksWithId.push({ task_id: task_id, task_name: $(this).val() });
  });

  $.ajax({
    type: "POST",
    url: "http://localhost/shop/admin/role/update",
    data: {
      role_id: roleId,
      tasks: selectedTasksWithId, // Sử dụng mảng selectedTasksWithId chứa task_id và task_name
    },
    success: function (response) {
      console.log(response);
      if (response.status === "success") {
        alert("Role information updated successfully!");
        // Nếu cần, thực hiện các hành động phản hồi khác sau khi cập nhật thành công
      } else {
        console.error("Error updating role:", response.message);
        alert(
          "An error occurred while updating the role. Please try again later."
        );
      }
    },
    error: function (xhr, status, error) {
      console.error("Error updating role:", xhr.responseText);
      alert(
        "An error occurred while updating the role. Please try again later."
      );
    },
  });
}

//show detail role

$(document).ready(function () {
  $("#roleList tbody tr").click(function () {
    var roleId = $(this).find("td:eq(1)").text();
    // console.log(roleId);
    // showListDetailRole(roleId);
  });
});

// load navigation
function loadNavigation() {
  var navigationContent = `
      <ul id="sidebarnav">
      <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">Trang chủ</span>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="./index.html" aria-expanded="false">
          <span>
            <i class="ti ti-layout-dashboard"></i>
          </span>
          <span class="hide-menu">Dashboard</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="http://localhost/shop/admin/account" aria-expanded="false">
          <span>
            <i class="ti ti-login"></i>
          </span>
          <span class="hide-menu">Quản lý tài khoản</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="http://localhost/shop/admin/role" aria-expanded="false">
          <span>
            <i class="ti ti-login"></i>
          </span>
          <span class="hide-menu">Quản lý phân quyền</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="./authentication-login.html" aria-expanded="false">
          <span>
            <i class="ti ti-login"></i>
          </span>
          <span class="hide-menu">Quản lý nhân viên</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="http://localhost/shop/admin/product" aria-expanded="false">
          <span>
            <i class="ti ti-login"></i>
          </span>
          <span class="hide-menu">Quản lý sản phẩm</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="./authentication-login.html" aria-expanded="false">
          <span>
            <i class="ti ti-login"></i>
          </span>
          <span class="hide-menu">Quản lý đơn hàng</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="<?php echo _WEB_ROOT; ?>/ImportController" aria-expanded="false">
          <span>
            <i class="ti ti-login"></i>
          </span>
          <span class="hide-menu">Quản lý nhập hàng</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="./authentication-login.html" aria-expanded="false">
          <span>
            <i class="ti ti-login"></i>
          </span>
          <span class="hide-menu">Quản lý bảo hành</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="./authentication-login.html" aria-expanded="false">
          <span>
            <i class="ti ti-login"></i>
          </span>
          <span class="hide-menu">Thống kê</span>
        </a>
      </li>
      <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">Chức năng</span>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="./authentication-login.html" aria-expanded="false">
          <span>
            <i class="ti ti-login"></i>
          </span>
          <span class="hide-menu">Đăng xuất</span>
        </a>
      </li>
    </ul>

  `;

  // Lấy thẻ nav
  var sidebarNav = document.querySelector(".sidebar-nav");

  sidebarNav.innerHTML = navigationContent;
}

// Gọi hàm loadNavigation() để tải nội dung navigation và xử lý sự kiện click
loadNavigation();


// Hàm để load navigation dựa trên quyền của người dùng
function loadNavigationBasedOnPermissions(userPermissions) {
  // Danh sách các chức năng và quyền tương ứng
  var navigationPermissions = {
      "Dashboard": ["view_dashboard"],
      "Quản lý tài khoản": ["manage_accounts"],
      "Quản lý phân quyền": ["manage_roles"],
      // Thêm các chức năng khác ở đây...
      "Đăng xuất": ["logout"] // Ví dụ cho chức năng Đăng xuất
  };

  // Lấy thẻ nav
  var sidebarNav = document.querySelector(".sidebar-nav");

  // Xóa nội dung navigation hiện tại
  sidebarNav.innerHTML = '';

  // Duyệt qua danh sách chức năng và quyền tương ứng để tạo navigation mới
  for (var navItemText in navigationPermissions) {
      if (navigationPermissions.hasOwnProperty(navItemText)) {
          var requiredPermissions = navigationPermissions[navItemText];
          // Kiểm tra xem người dùng có quyền thực hiện chức năng này không
          if (requiredPermissions.some(permission => userPermissions.includes(permission))) {
              // Nếu có quyền, thêm mục navigation tương ứng
              var navItem = document.createElement('li');
              navItem.classList.add('sidebar-item');
              var navLink = document.createElement('a');
              navLink.classList.add('sidebar-link');
              navLink.href = getLinkByNavItemText(navItemText); // Bạn cần cung cấp hàm này để lấy đường link tương ứng với chức năng
              navLink.setAttribute('aria-expanded', 'false');
              navLink.innerHTML = `
                  <span>
                      <i class="ti ti-login"></i>
                  </span>
                  <span class="hide-menu">${navItemText}</span>
              `;
              navItem.appendChild(navLink);
              sidebarNav.appendChild(navItem);
          }
      }
  }
}

// Hàm giả định để lấy đường link tương ứng với chức năng
function getLinkByNavItemText(navItemText) {
  // Giả sử bạn có một bản đồ chức năng (function map) và từ đó bạn có thể lấy đường link
  var functionMap = {
      "Dashboard": "./index.html",
      "Quản lý tài khoản": "http://localhost/shop/admin/account",
      "Quản lý phân quyền": "http://localhost/shop/admin/role",
      // Thêm các chức năng khác ở đây...
      "Đăng xuất": "./authentication-login.html" // Ví dụ cho chức năng Đăng xuất
  };
  return functionMap[navItemText];
}

// Đây là ví dụ về cách bạn có thể sử dụng hàm loadNavigationBasedOnPermissions
// Sau khi lấy thông tin quyền của người dùng, bạn có thể gọi hàm này để tải navigation tương ứng
var userPermissions = ["view_dashboard", "manage_accounts"]; // Ví dụ danh sách quyền của người dùng
// loadNavigationBasedOnPermissions(userPermissions);
