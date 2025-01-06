# LARAVEL CMS
## Table List

<ol>
  <li>Users</li>
  <li>Webs</li>
  <li>Categories</li>
  <li>Menus</li>
  <li>Posts</li>
  <li>Category_Post (n-to-n relation table)</li>
</ol>

---

### Table **User** Structure
1. id -  INT
1. web_id - INT
1. display_name - STRING 
1. username - STRING - UNIQUE
1. password - STRING
1. roles - ENUM(super_admin, web_admin)
1. created/updated_at - TIMESTAMP

### Table **Webs** Structure
1. id - INT
1. nama - STRING
1. subdomain - STRING
1. email - STRING
1. telepon - STRING
1. created_at/updated_at - TIMESTAMP

### Table **Categories** Structure
1. id - INT
1. web_id - INT
1. name - STRING
1. slug - STRING
1. description - TEXT
1. parent - INT
1. created_at/updated/at - TIMESTAMP

### Table Menus Structure
1. id - INT
1. web_id - INT
1. name - STRING
1. target - STRING
1. parent_id - INT
1. type - ENUM(custom,page/post, category)
1. menu_order - INT
1. created_at/updated_at - TIMESTAMP

### Table Posts
1. id - INT
1. web_id - INT
1. author - INT
1. title - STRING
1. slug - STRING
1. content - LONGTEXT
1. excerpt - STRING
1. type - ENUM(post,page)
1. status - ENUM(draft, publish)
1. deleted_at/created_at/updated_at

### Table Category_Post
1. id - INT
1. category_id - INT
1. post_id - INT

### Table Media
1. id - INT
1. web_id - INT
1. filename - STRING
1. mime_type - STRING
1. created_at/updated_at/deleted_at - TIMESTAMP

