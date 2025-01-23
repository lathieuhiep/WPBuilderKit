# Essential Features Addon

Essential Features Addon là một plugin bổ sung các tính năng tùy chỉnh, bao gồm quản lý Custom Post Type (CPT) và các tiện ích mở rộng cho Elementor.

---

## **Template Override Hướng dẫn**

Plugin cung cấp các template mặc định cho các kiểu hiển thị như `archive`, `single`, và `taxonomy` của Custom Post Type (CPT). Bạn có thể tùy chỉnh các template này bằng cách sao chép chúng vào thư mục theme của mình.

### **Cách thực hiện**

1. **Sao chép template từ plugin**  
   Các template mặc định được lưu trong thư mục sau:

        essential-features-addon/templates/

2. **Dán template vào theme**  
   Để tùy chỉnh, hãy sao chép file template từ plugin và dán vào thư mục `efa-templates` trong theme hoặc child theme của bạn.  
   Cấu trúc thư mục trong theme như sau:
   
       your-theme/
        └── efa-templates
             ├── archive-portfolio.php
             ├── single-portfolio.php

3. **Tự động ưu tiên sử dụng template từ theme**  
   Plugin sẽ tự động kiểm tra và ưu tiên sử dụng template từ thư mục `efa-templates` trong theme. Nếu không tìm thấy, plugin sẽ fallback về template mặc định trong plugin.

## **Liên hệ hỗ trợ**
Nếu bạn gặp vấn đề khi sử dụng plugin hoặc cần hướng dẫn thêm, vui lòng liên hệ qua email: [khacdiepkma90@gmail.com](mailto:khacdiepkma90@gmail.com).