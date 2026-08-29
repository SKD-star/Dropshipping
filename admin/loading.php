<div class="spinner-border text-primary load" role="status">
  <span class="sr-only">Loading...</span>
</div>


<script>
document.onreadystatechange = function()
{
  if (document.readyState !== "complete")
  {
    document.querySelector( 
    "body").style.visibility = "hidden"; 
    document.querySelector( 
    ".load").style.visibility = "visible"; 
  }
  else
  { 
    document.querySelector( 
    ".load").style.display = "none"; 
    document.querySelector( 
    "body").style.visibility = "visible"; 
  } 
}; 
</script>