<style>
    @media screen and (max-width: 767px) {
    .col-3 {
        width: 100%; 
        margin-bottom: 10px; 
    }
    .col-2 {
        width: 50%; 
        margin-bottom: 10px; 
    }
}
</style>
<style>
    .pagination {
  display: -ms-flexbox;
  display: flex;
  padding-left: 0;
  list-style: none;
  border-radius: 0.25rem;
  justify-content: center;
}
.page-link {
  position: relative;
  display: block;
  padding: 0.5rem 0.75rem;
  margin-left: -1px;
  line-height: 1.25;
  color: #3ED0CD;
  background-color: #fff;
  border: 1px solid #222;
}
.pagetop{
    margin-top:10px;
}
.page-link:hover {
  z-index: 2;
  color: #0056b3;
  text-decoration: none;
  background-color: #e9ecef;
  border-color: #222;
}
.page-link:focus {
  z-index: 3;
  outline: 0;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
.page-item:first-child .page-link {
  margin-left: 0;
  border-top-left-radius: 0.25rem;
  border-bottom-left-radius: 0.25rem;
}
.page-item:last-child .page-link {
  border-top-right-radius: 0.25rem;
  border-bottom-right-radius: 0.25rem;
}
.page-item.active .page-link {
  z-index: 3;
  color: #fff;
  background-color: #3ED0CD;
  border-color: #3ED0CD;
}
.page-item.disabled .page-link {
  color: #6c757d;
  pointer-events: none;
  cursor: auto;
  background-color: #fff;
  border-color: #222;
}
.pagination-lg .page-link {
  padding: 0.75rem 1.5rem;
  font-size: 1.25rem;
  line-height: 1.5;
}
.pagination-lg .page-item:first-child .page-link {
  border-top-left-radius: 0.3rem;
  border-bottom-left-radius: 0.3rem;
}
.pagination-lg .page-item:last-child .page-link {
  border-top-right-radius: 0.3rem;
  border-bottom-right-radius: 0.3rem;
}
.pagination-sm .page-link {
  padding: 0.25rem 0.5rem;
  font-size: 0.875rem;
  line-height: 1.5;
}
.pagination-sm .page-item:first-child .page-link {
  border-top-left-radius: 0.2rem;
  border-bottom-left-radius: 0.2rem;
}
.pagination-sm .page-item:last-child .page-link {
  border-top-right-radius: 0.2rem;
  border-bottom-right-radius: 0.2rem;
}
    .border-return-4{
        background-color: rgb(101 15 153 / 18%) !important;
    }
    .text-return {
    --bs-text-opacity: 1;
    color: rgb(101 15 153) !important;
    }
    .border-return {
    border-color: rgb(101 15 153) !important;
    }
    .text-success {
    --bs-text-opacity: 1;
    color: rgb(0 133 42) !important;
    }
    .border-success {
        border-color: rgb(0 133 42) !important;
    }
    .bg-success-4 {
    --bs-bg-opacity: 1;
    background-color: rgb(24 165 40 / 14%) !important;
    }
    .morten{
        width:20% !important;
    }
    .trashcann{
        margin-right: 5px;
    }
</style>
