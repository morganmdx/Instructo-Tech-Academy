<?php
/* Template Name: User Inbox */

get_header();


if (is_user_logged_in()) {
    $user_id = get_current_user_id();
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_notifications';

    // Fetch user notifications
    $notifications = $wpdb->get_results("SELECT * FROM $table_name WHERE user_id = $user_id ORDER BY date DESC");
    //var_dump($notifications); 
    ?>

    <main id="main" class="site-main">
        <div class="container">
            <h1><?php echo get_the_title(); ?></h1>
            <div class="inbox-container">
                <h2>Your Inbox</h2>

                <?php if ($notifications) : ?>
                    <ul class="inbox-messages">
                        <?php foreach ($notifications as $notification) : ?>
                            <li class="inbox-message <?= $notification->is_read ? 'read' : 'unread'; ?>" data-id="<?= $notification->id; ?>">
                                <?php if (!$notification->is_read) { ?>  <img src="data:image/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KDTwhLS0gVXBsb2FkZWQgdG86IFNWRyBSZXBvLCB3d3cuc3ZncmVwby5jb20sIFRyYW5zZm9ybWVkIGJ5OiBTVkcgUmVwbyBNaXhlciBUb29scyAtLT4KPHN2ZyB3aWR0aD0iODAwcHgiIGhlaWdodD0iODAwcHgiIHZpZXdCb3g9IjAgLTAuNSAyNSAyNSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KDTxnIGlkPSJTVkdSZXBvX2JnQ2FycmllciIgc3Ryb2tlLXdpZHRoPSIwIi8+Cg08ZyBpZD0iU1ZHUmVwb190cmFjZXJDYXJyaWVyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KDTxnIGlkPSJTVkdSZXBvX2ljb25DYXJyaWVyIj4gPHBhdGggZD0iTTE5Ljc1MDUgOS4wMjkwNUMxOS43NjUyIDkuNDQzIDIwLjExMjcgOS43NjY2MyAyMC41MjY3IDkuNzUxODlDMjAuOTQwNiA5LjczNzE1IDIxLjI2NDMgOS4zODk2MiAyMS4yNDk1IDguOTc1NjdMMTkuNzUwNSA5LjAyOTA1Wk0xNi4yMTQgNS4wMDIzNlY1Ljc1MjM2QzE2LjIyMjQgNS43NTIzNiAxNi4yMzA3IDUuNzUyMjIgMTYuMjM5MSA1Ljc1MTk0TDE2LjIxNCA1LjAwMjM2Wk05Ljc4NiA1LjAwMjM2TDkuNzYwOTUgNS43NTE5NEM5Ljc2OTMgNS43NTIyMiA5Ljc3NzY1IDUuNzUyMzYgOS43ODYgNS43NTIzNlY1LjAwMjM2Wk00Ljc1MDQ4IDguOTc1NjdDNC43MzU3MyA5LjM4OTYyIDUuMDU5MzYgOS43MzcxNSA1LjQ3MzMxIDkuNzUxODlDNS44ODcyNiA5Ljc2NjYzIDYuMjM0NzggOS40NDMgNi4yNDk1MiA5LjAyOTA1TDQuNzUwNDggOC45NzU2N1pNMjEuMjUgOS4wMDIzNkMyMS4yNSA4LjU4ODE1IDIwLjkxNDIgOC4yNTIzNiAyMC41IDguMjUyMzZDMjAuMDg1OCA4LjI1MjM2IDE5Ljc1IDguNTg4MTUgMTkuNzUgOS4wMDIzNkgyMS4yNVpNMjAuNSAxNS4wMDI0TDIxLjI0OTUgMTUuMDI5QzIxLjI0OTggMTUuMDIwMiAyMS4yNSAxNS4wMTEzIDIxLjI1IDE1LjAwMjRIMjAuNVpNMTYuMjE0IDE5LjAwMjRMMTYuMjM5MSAxOC4yNTI4QzE2LjIzMDcgMTguMjUyNSAxNi4yMjI0IDE4LjI1MjQgMTYuMjE0IDE4LjI1MjRWMTkuMDAyNFpNOS43ODYgMTkuMDAyNFYxOC4yNTI0QzkuNzc3NjUgMTguMjUyNCA5Ljc2OTMgMTguMjUyNSA5Ljc2MDk1IDE4LjI1MjhMOS43ODYgMTkuMDAyNFpNNS41IDE1LjAwMjRINC43NUM0Ljc1IDE1LjAxMTMgNC43NTAxNiAxNS4wMjAyIDQuNzUwNDggMTUuMDI5TDUuNSAxNS4wMDI0Wk02LjI1IDkuMDAyMzZDNi4yNSA4LjU4ODE1IDUuOTE0MjEgOC4yNTIzNiA1LjUgOC4yNTIzNkM1LjA4NTc5IDguMjUyMzYgNC43NSA4LjU4ODE1IDQuNzUgOS4wMDIzNkg2LjI1Wk0yMC44NzgzIDkuNjQ5OTZDMjEuMjM2IDkuNDQxMDMgMjEuMzU2NSA4Ljk4MTcyIDIxLjE0NzYgOC42MjQwNkMyMC45Mzg3IDguMjY2NCAyMC40Nzk0IDguMTQ1ODMgMjAuMTIxNyA4LjM1NDc2TDIwLjg3ODMgOS42NDk5NlpNMTUuMjM2IDEyLjA3NzRMMTQuODU3NyAxMS40Mjk3TDE0Ljg1MTUgMTEuNDMzNEwxNS4yMzYgMTIuMDc3NFpNMTAuNzY0IDEyLjA3NzRMMTEuMTQ4NiAxMS40MzM0TDExLjE0MjMgMTEuNDI5OEwxMC43NjQgMTIuMDc3NFpNNS44NzgzIDguMzU0NzZDNS41MjA2NCA4LjE0NTgzIDUuMDYxMzMgOC4yNjY0IDQuODUyNCA4LjYyNDA2QzQuNjQzNDcgOC45ODE3MiA0Ljc2NDA0IDkuNDQxMDMgNS4xMjE3IDkuNjQ5OTZMNS44NzgzIDguMzU0NzZaTTIxLjI0OTUgOC45NzU2N0MyMS4xNTM0IDYuMjc1MzYgMTguODg5NSA0LjE2MjUyIDE2LjE4ODkgNC4yNTI3OEwxNi4yMzkxIDUuNzUxOTRDMTguMTEyOSA1LjY4OTMxIDE5LjY4MzggNy4xNTUzNyAxOS43NTA1IDkuMDI5MDVMMjEuMjQ5NSA4Ljk3NTY3Wk0xNi4yMTQgNC4yNTIzNkg5Ljc4NlY1Ljc1MjM2SDE2LjIxNFY0LjI1MjM2Wk05LjgxMTA1IDQuMjUyNzhDNy4xMTA1NCA0LjE2MjUyIDQuODQ2NjMgNi4yNzUzNiA0Ljc1MDQ4IDguOTc1NjdMNi4yNDk1MiA5LjAyOTA1QzYuMzE2MjUgNy4xNTUzNyA3Ljg4NzEyIDUuNjg5MzEgOS43NjA5NSA1Ljc1MTk0TDkuODExMDUgNC4yNTI3OFpNMTkuNzUgOS4wMDIzNlYxNS4wMDI0SDIxLjI1VjkuMDAyMzZIMTkuNzVaTTE5Ljc1MDUgMTQuOTc1N0MxOS42ODM4IDE2Ljg0OTQgMTguMTEyOSAxOC4zMTU0IDE2LjIzOTEgMTguMjUyOEwxNi4xODg5IDE5Ljc1MTlDMTguODg5NSAxOS44NDIyIDIxLjE1MzQgMTcuNzI5NCAyMS4yNDk1IDE1LjAyOUwxOS43NTA1IDE0Ljk3NTdaTTE2LjIxNCAxOC4yNTI0SDkuNzg2VjE5Ljc1MjRIMTYuMjE0VjE4LjI1MjRaTTkuNzYwOTUgMTguMjUyOEM3Ljg4NzEyIDE4LjMxNTQgNi4zMTYyNCAxNi44NDk0IDYuMjQ5NTIgMTQuOTc1N0w0Ljc1MDQ4IDE1LjAyOUM0Ljg0NjYzIDE3LjcyOTQgNy4xMTA1NCAxOS44NDIyIDkuODExMDUgMTkuNzUxOUw5Ljc2MDk1IDE4LjI1MjhaTTYuMjUgMTUuMDAyNFY5LjAwMjM2SDQuNzVWMTUuMDAyNEg2LjI1Wk0yMC4xMjE3IDguMzU0NzZMMTQuODU3NyAxMS40Mjk4TDE1LjYxNDMgMTIuNzI1TDIwLjg3ODMgOS42NDk5NkwyMC4xMjE3IDguMzU0NzZaTTE0Ljg1MTUgMTEuNDMzNEMxMy43MTExIDEyLjExNDUgMTIuMjg4OSAxMi4xMTQ1IDExLjE0ODUgMTEuNDMzNEwxMC4zNzk1IDEyLjcyMTNDMTEuOTkzNSAxMy42ODUyIDE0LjAwNjUgMTMuNjg1MiAxNS42MjA1IDEyLjcyMTNMMTQuODUxNSAxMS40MzM0Wk0xMS4xNDIzIDExLjQyOThMNS44NzgzIDguMzU0NzZMNS4xMjE3IDkuNjQ5OTZMMTAuMzg1NyAxMi43MjVMMTEuMTQyMyAxMS40Mjk4WiIgZmlsbD0iIzBiMzk1NCIvPiA8L2c+Cg08L3N2Zz4=" width="70" class="inbox-icon"> 
                                <?php } else { ?> <img src="data:image/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KDTwhLS0gVXBsb2FkZWQgdG86IFNWRyBSZXBvLCB3d3cuc3ZncmVwby5jb20sIFRyYW5zZm9ybWVkIGJ5OiBTVkcgUmVwbyBNaXhlciBUb29scyAtLT4KPHN2ZyB3aWR0aD0iODAwcHgiIGhlaWdodD0iODAwcHgiIHZpZXdCb3g9IjAgLTAuNSAyNSAyNSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KDTxnIGlkPSJTVkdSZXBvX2JnQ2FycmllciIgc3Ryb2tlLXdpZHRoPSIwIi8+Cg08ZyBpZD0iU1ZHUmVwb190cmFjZXJDYXJyaWVyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KDTxnIGlkPSJTVkdSZXBvX2ljb25DYXJyaWVyIj4gPHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik05LjUyMDg2IDE4Ljk5N0M3LjM4OTk0IDE5LjA2MzkgNS42MDYyOSAxNy4zOTQ3IDUuNTMxODcgMTUuMjY0VjExLjUzTDUuNTI2ODcgOS42NjRDNS4zOTg0MSA4Ljk4Nzk4IDUuNzM5NTIgOC4zMDk4NiA2LjM1ODg3IDguMDFMMTAuNDAzOSA1LjU5N0MxMS43MDMgNC44MDEgMTMuMzM4OCA0LjgwMSAxNC42Mzc5IDUuNTk3TDE4LjY4MjkgOC4wMTNDMTkuMzAyMiA4LjMxMjg2IDE5LjY0MzMgOC45OTA5OCAxOS41MTQ5IDkuNjY3TDE5LjUwOTkgMTEuNTM0VjE1LjI2N0MxOS40MzM4IDE3LjM5NjUgMTcuNjUwNyAxOS4wNjM5IDE1LjUyMDkgMTguOTk3SDkuNTIwODZaIiBzdHJva2U9IiMyMjIyMjIiIHN0cm9rZS13aWR0aD0iMS41IiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4gPHBhdGggZD0iTTUuOTA1MzMgOS4wMTY1MUM1LjU0NzczIDguODA3NDggNS4wODgzOCA4LjkyNzkzIDQuODc5MzYgOS4yODU1M0M0LjY3MDMzIDkuNjQzMTQgNC43OTA3NyAxMC4xMDI1IDUuMTQ4MzggMTAuMzExNUw1LjkwNTMzIDkuMDE2NTFaTTEwLjQzNjkgMTIuNTM0TDEwLjgyMTkgMTEuODkwM0wxMC44MTUzIDExLjg4NjVMMTAuNDM2OSAxMi41MzRaTTE0LjYwMzkgMTIuNTM0TDE0LjIyNTQgMTEuODg2NUwxNC4yMTg5IDExLjg5MDRMMTQuNjAzOSAxMi41MzRaTTE5Ljg5MjMgMTAuMzExNUMyMC4yNDk5IDEwLjEwMjUgMjAuMzcwNCA5LjY0MzE0IDIwLjE2MTQgOS4yODU1M0MxOS45NTIzIDguOTI3OTMgMTkuNDkzIDguODA3NDggMTkuMTM1NCA5LjAxNjUxTDE5Ljg5MjMgMTAuMzExNVpNMTQuMzM5IDkuNzI0NjJDMTQuNzQwOCA5LjgyNTA4IDE1LjE0OCA5LjU4MDc2IDE1LjI0ODUgOS4xNzg5MUMxNS4zNDg5IDguNzc3MDYgMTUuMTA0NiA4LjM2OTg2IDE0LjcwMjggOC4yNjk0TDE0LjMzOSA5LjcyNDYyWk0xMi41MjA5IDguNDk3MDFMMTIuNzAyOCA3Ljc2OTRDMTIuNTgzMyA3LjczOTU0IDEyLjQ1ODQgNy43Mzk1NCAxMi4zMzkgNy43Njk0TDEyLjUyMDkgOC40OTcwMVpNMTAuMzM5IDguMjY5NEM5LjkzNzExIDguMzY5ODYgOS42OTI3OSA4Ljc3NzA2IDkuNzkzMjUgOS4xNzg5MUM5Ljg5MzcxIDkuNTgwNzYgMTAuMzAwOSA5LjgyNTA4IDEwLjcwMjggOS43MjQ2MkwxMC4zMzkgOC4yNjk0Wk01LjE0ODM4IDEwLjMxMTVMMTAuMDU4NCAxMy4xODE1TDEwLjgxNTMgMTEuODg2NUw1LjkwNTMzIDkuMDE2NTFMNS4xNDgzOCAxMC4zMTE1Wk0xMC4wNTE5IDEzLjE3NzdDMTEuNTcyIDE0LjA4NjggMTMuNDY4OCAxNC4wODY4IDE0Ljk4ODggMTMuMTc3N0wxNC4yMTg5IDExLjg5MDRDMTMuMTcyOSAxMi41MTU5IDExLjg2NzggMTIuNTE1OSAxMC44MjE4IDExLjg5MDRMMTAuMDUxOSAxMy4xNzc3Wk0xNC45ODIzIDEzLjE4MTVMMTkuODkyMyAxMC4zMTE1TDE5LjEzNTQgOS4wMTY1MUwxNC4yMjU0IDExLjg4NjVMMTQuOTgyMyAxMy4xODE1Wk0xNC43MDI4IDguMjY5NEwxMi43MDI4IDcuNzY5NEwxMi4zMzkgOS4yMjQ2MkwxNC4zMzkgOS43MjQ2MkwxNC43MDI4IDguMjY5NFpNMTIuMzM5IDcuNzY5NEwxMC4zMzkgOC4yNjk0TDEwLjcwMjggOS43MjQ2MkwxMi43MDI4IDkuMjI0NjJMMTIuMzM5IDcuNzY5NFoiIGZpbGw9IiMyMjIyMjIiLz4gPC9nPgoNPC9zdmc+" width="70" class="inbox-icon"> <?php } ?>
                                <div style="display: inline-block;">
                                    <p><?= esc_html($notification->message); ?></p>
                                    <small><?= esc_html($notification->date); ?></small>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p>No messages in your inbox.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.inbox-message.unread').forEach(function(item) {
                item.addEventListener('click', function() {
                    const messageId = item.getAttribute('data-id');
                    fetch(`<?php echo admin_url('admin-ajax.php'); ?>?action=mark_as_read&message_id=${messageId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'message_id=' + messageId
                    }).then(() => {
                        item.classList.remove('unread');
                        item.classList.add('read');
                    });
                });
            });
        });
    </script>

    <?php
} else { ?>
    <main id="main" class="site-main">
        <div class="container">
            <h1><?php echo get_the_title(); ?></h1>
            <div class="inbox-container">
                <h2>Your Notifications</h2>

                <p> Please log in to view your inbox. </p>
            </div>
        </div>
    </main>
<?php }

