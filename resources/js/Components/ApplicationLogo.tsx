import { SVGAttributes } from 'react';

export default function ApplicationLogo(props: SVGAttributes<SVGElement>) {
    return (
       <img src={"/assets/logo.png"} alt="Logo" className="h-9" />
    );
}
