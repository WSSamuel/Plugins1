import {HTMLAttributes, Key} from "react";

export {};

declare global {
    namespace JSX {
        interface FilkersFolderElementAttributes extends HTMLAttributes<HTMLElement> {
            key?: Key
            uid: string,
            noerrors?: boolean,
            random?: boolean,
            href?: string,
            target?: string,
            speed?: number,
            class?: string
            arrows?: string,
            dots?: string,
        }

        interface IntrinsicElements {
            'filkers-folder': FilkersFolderElementAttributes
        }
    }
}