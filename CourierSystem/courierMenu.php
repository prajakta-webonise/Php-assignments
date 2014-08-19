<style>
a{
	display: block;
	padding: 5px;
	

}
</style>
<?php
//Displaying user name and menus.
echo '<span>Welcome&nbsp'. $_COOKIE['user_name'].'</span>'; 
echo '<a href="addBookShelf.php">Add BookShelf</a>
  		<a href="editBookShelf.php">Edit BookShelf</a>
  		<a href="deleteBookShelf.php">Delete BookShelf</a>
  		<a href="showBookShelf.php">Show all BookShelf</a>
  		<a href="addBook.php">Add Book</a>
  		<a href="editBooks.php">Edit Book</a>
  		<a href="deleteBook.php">Delete Book</a>
  		<a href="showBook.php">Show all Books</a>
      <h4>My Own Stories</h4>
      <a href="createFiles.php">Create Stories</a>
      <a href="showFiles.php">My Stories</a>
      <a href="fileUpload.php">Upload Story</a>';

?>