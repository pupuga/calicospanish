<?php

namespace Pupuga\Custom\Shop;

class Memberships
{
    protected $init;

    public function __construct(Init $init)
    {
        $this->init = $init;
        $this->hooks();
    }

    private function hooks()
    {
        add_action( 'wc_memberships_grant_membership_access_from_purchase', array($this, 'oneActiveMembershipOtherCanceled'), 10, 2);
        add_filter( 'wc_memberships_members_area_my-memberships_actions', array($this, 'correctButtonOnMembershipPanel'), 10, 2 );
    }

    public function oneActiveMembershipOtherCanceled($plan, $args)
    {
        $this->oneSubscription()
            ->oneMembership($args['user_id']);
    }

    public function correctButtonOnMembershipPanel( $actions, $userMembership ) {

        if (isset($actions['view-subscription'])) {
            if (sanitize_title($userMembership->get_plan()->post->post_title) == 'free-trial') {
                unset($actions['view-subscription']);
            } else {
                $actions['view-subscription']['name'] = 'Manage Your Subscription';
            }
        }

        if (isset($actions['view'])) {
            unset($actions['view']);
        }

        return $actions;
    }

    private function oneSubscription()
    {
        $subscriptions = wcs_get_users_subscriptions();
        $subscriptionsCount = count($subscriptions);
        if ($subscriptionsCount > 1) {
            $i = 0;
            foreach ($subscriptions as $subscription) {
                $i++;
                $status = $subscription->get_status();
                if ($i === $subscriptionsCount) {
                    continue;
                } elseif ($status == 'active') {
                    $subscription->update_status('cancelled', 'Your subscription has been cancelled.');
                }
            }
        }

        return $this;
    }

    private function oneMembership($userId)
    {
        $memberships = wc_memberships_get_user_active_memberships($userId);
        if (count($memberships) > 0) {
            $first = true;
            foreach ($memberships as $membership) {
                if ($first) {
                    $first = false;
                } else {
                    $membership->cancel_membership();
                }
            }
        }

        return $this;
    }
}