# WPBuilderKit

WPBuilderKit là bộ công cụ phát triển Theme và Plugin cho WordPress, được thiết kế để dễ dàng tùy chỉnh và mở rộng cho các dự án WordPress sử dụng Elementor.

## Cấu trúc Dự Án

Dự án bao gồm:

- `dist/` : Chứa mã nguồn đã build của theme và plugin.
    - `theme/` : Theme WordPress.
    - `plugins/` : Các plugin phát triển cho theme.

- `src/` : Mã nguồn phát triển của theme và plugin.
    - `theme/` : Các tệp SCSS, JS và template cho theme.
    - `plugins/` : Các tệp SCSS, JS cho plugin.
    - `shared/` : Các tệp SCSS, JS dùng chung giữa theme và plugin.

- `gulpfile.js` : Cấu hình Gulp để biên dịch SCSS, tối ưu hóa JS và thực hiện các tác vụ tự động.

## Yêu cầu Hệ thống

- Node.js (Lý tưởng là phiên bản LTS)
- NPM (được cài đặt cùng Node.js)
- Gulp CLI

## Cài đặt Dự Án

1. **Clone dự án từ Git**:
   ```bash
   git clone https://github.com/lathieuhiep/WPBuilderKit.git
   cd WPBuilderKit
   
2. **Cài đặt các phụ thuộc**:

- Chạy lệnh sau để cài đặt tất cả các phụ thuộc cần thiết:

    ```bash
    npm install
   
3. **Cấu hình Symbolic Link (tùy chọn)**:

- Để phát triển dễ dàng, bạn có thể sử dụng symbolic link để trỏ theme và plugin từ thư mục dist/ đến thư mục wp-content của WordPress.
- Mở Command Prompt hoặc PowerShell với quyền admin.
    
  - Tạo symbolic link cho theme:
      ```bash
      mklink /D "PATH_TO_WP_CONTENT/themes/THEME_NAME" "PATH_TO_WPBUILDERKIT/dist/theme/THEME_NAME"
    
  - Giải thích:

    - PATH_TO_WP_CONTENT: Đây là đường dẫn đến thư mục wp-content của cài đặt WordPress của bạn.
    - THEME_NAME: Đây là tên theme bạn đang làm việc.
    - PATH_TO_WPBUILDERKIT: Đây là đường dẫn đến thư mục dự án WPBuilderKit, nơi chứa mã nguồn của theme bạn.


  - Tạo symbolic link cho plugin:
    ```bash
    mklink /D "PATH_TO_WP_CONTENT/plugins/PLUGIN_NAME" "PATH_TO_WPBUILDERKIT/dist/plugins/PLUGIN_NAME"

  - Giải thích:

    - PATH_TO_WP_CONTENT: Đây là đường dẫn đến thư mục wp-content của cài đặt WordPress của bạn.
    - PLUGIN_NAME: Đây là tên plugin bạn đang phát triển.
    - PATH_TO_WPBUILDERKIT: Đây là đường dẫn đến thư mục dự án WPBuilderKit, nơi chứa mã nguồn của plugin bạn.

## Liên Hệ

Nếu bạn gặp vấn đề hoặc có câu hỏi nào liên quan đến dự án, vui lòng mở issue trên GitHub hoặc liên hệ qua
- email: khacdiepkma90@gmail.com