<?php
$con = mysqli_connect("localhost","root","","keyword_db");

// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Get Data From URL and Perform queries
if(isset($_GET['search']))
{
    $search_key = $_GET['search'];
    $previous_search = mysqli_query($con,"SELECT * FROM searched WHERE keyword = '$search_key'");
    if($previous_search && mysqli_num_rows($previous_search) > 0)
    {
        $previous_search_count = mysqli_query($con,"SELECT times FROM searched WHERE keyword = '$search_key'");
        $search_count = mysqli_fetch_assoc($previous_search_count);
        $new_search_count = ++$search_count['times'];
        mysqli_query($con,"UPDATE searched SET times='$new_search_count' WHERE keyword = '$search_key'");
    }
    else 
    {
        mysqli_query($con,"INSERT INTO searched VALUES ('$search_key', 1)");
    }
}
if(isset($_GET['copy']))
{
    $copy_key = $_GET['copy'];
    mysqli_query($con,"INSERT INTO copied VALUES ('$copy_key', 1)");
}

mysqli_close($con);
?>