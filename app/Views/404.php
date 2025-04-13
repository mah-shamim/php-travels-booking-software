<div class="bg py-5">
<div class="card-center text-center mt-5 mb-5 pb-6 pt-5">
    <h1 class="center-text mb-5">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
    </h1>
    <h1 class="center-text fa-5x mb-3"><strong><?=T::error?></strong></h1>
    <h6 class="center-text font-800 font-14 mb-4"><?=T::page_not_found_404?></h6>

    <div class="container mt-5">
        <div class="row me-5 ms-5 mb-0">
            <div class="col-6">
                <a href="<?=root?>" class="w-100 btn btn-outline-dark back-button ms-2 btn btn-m bg-highlight rounded-sm btn-full text-uppercase font-900 shadow-l"><?=T::home?></a>
            </div>
            <div class="col-6">
                <a href="<?=root?>contact-us" class="w-100 btn btn-dark back-button me-2 btn btn-m bg-highlight rounded-sm btn-full text-uppercase font-900 shadow-l"><?=strtoupper(T::contact);?></a>
            </div>
            <div class="claerfix"></div>
        </div>
    </div>
</div>
</div>