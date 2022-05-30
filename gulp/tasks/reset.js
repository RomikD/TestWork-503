/**
 *  This is reset function to clean compiled files in real time from ./source/dist for new regenerate files
 */

 import del from "del";

 export const reset = () => {
     return del(
         app.path.clean
     );
 }