<footer>
    <div class="container">
        <div class="contact-wrap">
            <div class="info-block">
                <div class='info-pic'>
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="37" viewBox="0 0 36 37" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M18 1.13477C10.7513 1.13477 4.875 7.01103 4.875 14.2598C4.875 15.8384 5.44319 17.6717 6.24825 19.5105C7.0641 21.3741 8.17359 23.3541 9.36171 25.2585C11.7388 29.0687 14.4865 32.6643 15.9903 34.5626C17.0219 35.8644 18.9781 35.8644 20.0097 34.5626C21.5136 32.6643 24.2612 29.0687 26.6383 25.2585C27.8263 23.3541 28.9359 21.3741 29.7517 19.5105C30.5568 17.6717 31.125 15.8384 31.125 14.2598C31.125 7.01103 25.2488 1.13477 18 1.13477ZM18 7.13477C14.4792 7.13477 11.625 9.98895 11.625 13.5098C11.625 17.0306 14.4792 19.8848 18 19.8848C21.5208 19.8848 24.375 17.0306 24.375 13.5098C24.375 9.98895 21.5208 7.13477 18 7.13477Z"
                            fill="white" />
                    </svg>
                </div>
                <div class="contact-text-wrap">
                    <a href='<?php the_field('address_link', 'option') ?>'
                        target='_blank'><?php the_field('address', 'option') ?></a>
                </div>
            </div>
            <div class="info-block">
                <div class='info-pic'>
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="37" viewBox="0 0 36 37" fill="none">
                        <g clip-path="url(#clip0_534_2782)">
                            <path
                                d="M35.0202 27.1801L29.9963 22.1562C28.2021 20.362 25.1518 21.0798 24.4341 23.4122C23.8959 25.0271 22.1016 25.9242 20.4868 25.5653C16.8983 24.6682 12.0538 20.0031 11.1567 16.2352C10.6184 14.6203 11.6949 12.826 13.3098 12.2878C15.6423 11.5701 16.36 8.51991 14.5657 6.72566L9.54183 1.70175C8.10643 0.445771 5.95333 0.445771 4.69735 1.70175L1.28827 5.11083C-2.12081 8.69933 1.64712 18.2089 10.0801 26.6419C18.5131 35.0748 28.0226 39.0223 31.6111 35.4337L35.0202 32.0246C36.2763 30.5892 36.2763 28.4361 35.0202 27.1801Z"
                                fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_534_2782">
                                <rect width="36" height="36" fill="white" transform="translate(0 0.759766)" />
                            </clipPath>
                        </defs>
                    </svg>
                </div>

                <div class="contact-text-wrap">
                    <a href="tel:<?php the_field('phone', 'option') ?>"><?php the_field('phone', 'option') ?></a>
                    <a
                        href="tel:<?php the_field('second_phone', 'option') ?>"><?php the_field('second_phone', 'option') ?></a>
                </div>
            </div>
            <div class="info-block">
                <div class='info-pic'>

                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="37" viewBox="0 0 36 37" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M2.8913 6.42955L13.7106 17.2535C16.0703 19.6087 19.9276 19.6108 22.2893 17.2535L33.1086 6.42955C33.2176 6.32059 33.2017 6.14116 33.0753 6.053C31.9718 5.2834 30.6291 4.82715 29.1829 4.82715H6.81713C5.37078 4.82715 4.02814 5.28348 2.92462 6.053C2.79822 6.14116 2.78234 6.32059 2.8913 6.42955ZM0 11.6442C0 10.5069 0.281981 9.43231 0.778674 8.48782C0.856346 8.34006 1.05322 8.31018 1.17126 8.42821L11.8536 19.1106C15.2364 22.4982 20.7616 22.5002 24.1464 19.1106L34.8287 8.42821C34.9468 8.31018 35.1437 8.34006 35.2213 8.48782C35.7179 9.43231 36 10.507 36 11.6442V25.8752C36 29.637 32.94 32.6923 29.1829 32.6923H6.81713C3.0601 32.6923 0 29.637 0 25.8752V11.6442Z"
                            fill="white" />
                    </svg>
                </div>

                <div class="contact-text-wrap">
                    <a href="mailto:<?php the_field('email', 'option') ?>"><?php the_field('email', 'option') ?></a>
                    <a href="https://<?php the_field('email', 'option') ?>"><?php the_field('website', 'option') ?></a>
                </div>
            </div>
            <div class="subscribe-field">
                <p><?php the_field('subscription_title', 'option') ?></p>
                <form class="subscribe-form">
                    <input type="email" placeholder="Email">
                    <button class='subscribe-button gradient-button' type="submit">Subscribe</button>
                </form>
            </div>
        </div>
        <hr class="line footer">
        <div class="footer-info">
            <div class="social-wrap">
                <a href="<?php the_field('social_link', 'option') ?>">
                    <svg width="36" height="37" viewBox="0 0 36 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="18" cy="18.7598" r="17.5" stroke="white" />
                        <g clip-path="url(#clip0_499_2770)">
                            <path
                                d="M22 10.7598H14C11.792 10.7598 10 12.5518 10 14.7598V22.7598C10 24.9678 11.792 26.7598 14 26.7598H22C24.208 26.7598 26 24.9678 26 22.7598V14.7598C26 12.5518 24.208 10.7598 22 10.7598ZM18 22.7598C15.792 22.7598 14 20.9678 14 18.7598C14 16.5518 15.792 14.7598 18 14.7598C20.208 14.7598 22 16.5518 22 18.7598C22 20.9678 20.208 22.7598 18 22.7598ZM22.28 15.2558C21.84 15.2558 21.48 14.8958 21.48 14.4558C21.48 14.0158 21.84 13.6558 22.28 13.6558C22.72 13.6558 23.08 14.0158 23.08 14.4558C23.08 14.8958 22.72 15.2558 22.28 15.2558Z"
                                fill="white" />
                            <path
                                d="M18.0001 21.1599C19.3256 21.1599 20.4001 20.0853 20.4001 18.7599C20.4001 17.4344 19.3256 16.3599 18.0001 16.3599C16.6746 16.3599 15.6001 17.4344 15.6001 18.7599C15.6001 20.0853 16.6746 21.1599 18.0001 21.1599Z"
                                fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_499_2770">
                                <rect width="16" height="16" fill="white" transform="translate(10 10.7598)" />
                            </clipPath>
                        </defs>
                    </svg>
                </a>
                <a href="<?php the_field('social_link_second', 'option') ?>">
                    <svg width="36" height="37" viewBox="0 0 36 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="18" cy="18.7598" r="17.5" stroke="white" />
                        <g clip-path="url(#clip0_499_2776)">
                            <path
                                d="M16.0876 19.7911C16.0275 19.7911 14.7058 19.7911 14.1051 19.7911C13.7847 19.7911 13.6846 19.6709 13.6846 19.3705C13.6846 18.5695 13.6846 17.7485 13.6846 16.9475C13.6846 16.6271 13.8047 16.527 14.1051 16.527H16.0876C16.0876 16.4669 16.0876 15.3054 16.0876 14.7648C16.0876 13.9638 16.2277 13.2028 16.6282 12.5019C17.0488 11.781 17.6495 11.3004 18.4105 11.0201C18.9111 10.8399 19.4117 10.7598 19.9524 10.7598H21.9149C22.1952 10.7598 22.3154 10.8799 22.3154 11.1603V13.4431C22.3154 13.7235 22.1952 13.8436 21.9149 13.8436C21.3742 13.8436 20.8335 13.8436 20.2928 13.8636C19.7522 13.8636 19.4718 14.124 19.4718 14.6847C19.4518 15.2854 19.4718 15.8661 19.4718 16.4869H21.7947C22.1151 16.4869 22.2353 16.6071 22.2353 16.9275V19.3505C22.2353 19.6709 22.1351 19.771 21.7947 19.771C21.0738 19.771 19.5319 19.771 19.4718 19.771V26.2992C19.4718 26.6396 19.3717 26.7598 19.0112 26.7598C18.1702 26.7598 17.3492 26.7598 16.5081 26.7598C16.2077 26.7598 16.0876 26.6396 16.0876 26.3392C16.0876 24.2366 16.0876 19.8511 16.0876 19.7911Z"
                                fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_499_2776">
                                <rect width="16" height="16" fill="white" transform="translate(10 10.7598)" />
                            </clipPath>
                        </defs>
                    </svg>
                </a>
            </div>
            <p>© <?php echo date('Y'); ?>. All rights reserved.</p>
            <a href="https://ut.in.ua" target='_blank'>Developed by UT</a>
        </div>
    </div>
</footer>